<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
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

    /** @var CacheManager */
    private $cacheManager;

    /** @var OptimizedImageWriterInterface */
    private $optimizedImageWriter;

    /** @var ImageFileFactoryInterface */
    private $imageFileFactory;

    /** @var MessageBusInterface */
    private $eventBus;

    public function __construct(
        OptimizerInterface $optimizer,
        ManagerRegistry $managerRegistry,
        CacheManager $cacheManager,
        OptimizedImageWriterInterface $optimizedImageWriter,
        ImageFileFactoryInterface $imageFileFactory,
        MessageBusInterface $eventBus
    ) {
        $this->optimizer = $optimizer;
        $this->managerRegistry = $managerRegistry;
        $this->cacheManager = $cacheManager;
        $this->optimizedImageWriter = $optimizedImageWriter;
        $this->imageFileFactory = $imageFileFactory;
        $this->eventBus = $eventBus;
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

        foreach ($message->getFilterSets() as $filterSet) {
            $url = $this->cacheManager->getBrowserPath($message->getPath(), $filterSet);
            $imageFile = $this->imageFileFactory->createFromUrl($url);

            $result = $this->optimizer->optimize($imageFile);
            $this->handleOptimizationResult($result, $imageFile, $message->getPath(), $filterSet);

            if ($this->optimizer instanceof WebPOptimizerInterface) {
                $result = $this->optimizer->optimizeAndConvertToWebP($imageFile);
                $this->handleOptimizationResult($result, $imageFile, $message->getPath(), $filterSet);
            }
        }

        $image->setOptimized();

        $manager = $this->getManager($message->getClass());
        $manager->flush();
    }

    private function handleOptimizationResult(
        OptimizationResultInterface $optimizationResult,
        ImageFile $imageFile,
        string $path,
        string $filterSet
    ): void {
        $this->optimizedImageWriter->write($optimizationResult, $path, $filterSet);

        $this->eventBus->dispatch(new ImageFileOptimized($imageFile, $optimizationResult));
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
