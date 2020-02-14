<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use function Safe\sprintf;
use Setono\SyliusImageOptimizerPlugin\Factory\ImageFileFactoryInterface;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeImage;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableInterface;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizerInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class OptimizeImageHandler implements MessageHandlerInterface
{
    /** @var OptimizerInterface */
    private $optimizer;

    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var CacheManager */
    private $cacheManager;

    /** @var ImageFileFactoryInterface */
    private $imageFileFactory;

    public function __construct(OptimizerInterface $optimizer, ManagerRegistry $managerRegistry, CacheManager $cacheManager, ImageFileFactoryInterface $imageFileFactory)
    {
        $this->optimizer = $optimizer;
        $this->managerRegistry = $managerRegistry;
        $this->cacheManager = $cacheManager;
        $this->imageFileFactory = $imageFileFactory;
    }

    public function __invoke(OptimizeImage $message): void
    {
        $manager = $this->getManager($message->getClass());

        /** @var ImageInterface|OptimizableInterface|null $image */
        $image = $manager->createQueryBuilder()
            ->select('o')
            ->from($message->getClass(), 'o')
            ->andWhere('o.id = :id')
            ->setParameter('id', $message->getId())
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $image) {
            throw new UnrecoverableMessageHandlingException(sprintf(
                'The image %s with id %s does not exist', $message->getClass(), $message->getId()
            ));
        }

        foreach ($message->getFilterSets() as $filterSet) {
            $url = $this->cacheManager->getBrowserPath($message->getPath(), $filterSet);

            $result = $this->optimizer->optimize($this->imageFileFactory->createFromUrl($url));
        }

        $image->setOptimized();

        $manager->flush();
    }

    private function getManager(string $class): EntityManagerInterface
    {
        /** @var EntityManagerInterface $manager */
        $manager = $this->managerRegistry->getManagerForClass($class);

        return $manager;
    }
}
