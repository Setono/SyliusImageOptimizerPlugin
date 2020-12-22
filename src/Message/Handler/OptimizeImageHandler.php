<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Liip\ImagineBundle\Service\FilterService;
use Psr\Log\LoggerInterface;
use function Safe\sprintf;
use Setono\SyliusImageOptimizerPlugin\Factory\ImageFileFactoryInterface;
use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeImage;
use Setono\SyliusImageOptimizerPlugin\Message\Event\ImageFileOptimized;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableInterface;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizerInterface;
use Setono\SyliusImageOptimizerPlugin\Optimizer\WebPOptimizerInterface;
use Setono\SyliusImageOptimizerPlugin\Writer\OptimizedImageWriterInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OptimizeImageHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $manager;

    /** @var OptimizerInterface */
    private $optimizer;

    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var FilterService */
    private $filterService;

    /** @var OptimizedImageWriterInterface */
    private $optimizedImageWriter;

    /** @var ImageFileFactoryInterface */
    private $imageFileFactory;

    /** @var MessageBusInterface */
    private $eventBus;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        OptimizerInterface $optimizer,
        ManagerRegistry $managerRegistry,
        FilterService $filterService,
        OptimizedImageWriterInterface $optimizedImageWriter,
        ImageFileFactoryInterface $imageFileFactory,
        MessageBusInterface $eventBus,
        LoggerInterface $logger
    ) {
        $this->optimizer = $optimizer;
        $this->managerRegistry = $managerRegistry;
        $this->filterService = $filterService;
        $this->optimizedImageWriter = $optimizedImageWriter;
        $this->imageFileFactory = $imageFileFactory;
        $this->eventBus = $eventBus;
        $this->logger = $logger;
    }

    public function __invoke(OptimizeImage $message): void
    {
        $image = $this->getImage($message->getClass(), $message->getId());

        if (!$image instanceof OptimizableInterface) {
            throw new UnrecoverableMessageHandlingException(sprintf(
                'The class %s does not implement the interface %s',
                $message->getClass(), OptimizableInterface::class
            ));
        }

        $exceptions = [];

        foreach ($message->getFilterSets() as $filterSet) {
            try {
                $url = $this->filterService->getUrlOfFilteredImage($message->getPath(), $filterSet);
                $imageFile = $this->imageFileFactory->createFromUrl($url);

                $result = $this->optimizer->optimize($imageFile);
                $this->handleOptimizationResult(
                    $message->getImageResource(), $result, $imageFile, $message->getPath(), $filterSet
                );

                if ($this->optimizer instanceof WebPOptimizerInterface) {
                    $result = $this->optimizer->optimizeAndConvertToWebP($imageFile);
                    $this->handleOptimizationResult(
                        $message->getImageResource(), $result, $imageFile, $message->getPath(), $filterSet
                    );
                }
            } catch (\Throwable $e) {
                $exceptions[] = $e;
            }
        }

        // todo notice we are catching exceptions above meaning that an image can fail in optimization, but still be marked as optimized
        // todo this is done as an easy fix right now to solve the problem where a command keeps trying to optimize an image that fails
        $image->setOptimized();

        $manager = $this->getManager($message->getClass());
        $manager->flush();

        if (count($exceptions) > 0) {
            $errors = array_map(static function (\Throwable $e): string {
                return $e->getMessage();
            }, $exceptions);

            $this->logger->error(sprintf(
                "An error occurred during optimization of image %s with id %s. Errors:\n%s",
                $message->getClass(), $message->getId(), '- ' . implode("\n- ", $errors)
            ));
        }
    }

    private function handleOptimizationResult(
        string $imageResource,
        OptimizationResultInterface $optimizationResult,
        ImageFile $imageFile,
        string $path,
        string $filterSet
    ): void {
        $this->optimizedImageWriter->write($optimizationResult, $path, $filterSet);

        $this->eventBus->dispatch(new ImageFileOptimized($imageResource, $imageFile, $optimizationResult));
    }

    /**
     * @param mixed $id
     */
    private function getImage(string $class, $id): ImageInterface
    {
        $manager = $this->getManager($class);

        try {
            /** @var ImageInterface|null $image */
            $image = $manager->createQueryBuilder()
                ->select('o')
                ->from($class, 'o')
                ->andWhere('o.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new UnrecoverableMessageHandlingException($e->getMessage());
        }

        if (null === $image) {
            throw new UnrecoverableMessageHandlingException(sprintf(
                'The image %s with id %s does not exist', $class, $id
            ));
        }

        return $image;
    }

    private function getManager(string $class): EntityManagerInterface
    {
        if (null === $this->manager) {
            /** @var EntityManagerInterface $manager */
            $manager = $this->managerRegistry->getManagerForClass($class);

            $this->manager = $manager;
        }

        return $this->manager;
    }
}
