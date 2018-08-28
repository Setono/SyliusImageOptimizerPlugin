<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Persister;

use Doctrine\ORM\NonUniqueResultException;
use Loevgaard\SyliusOptimizeImagesPlugin\Entity\ImageOptimizationResult;
use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\AggregateOptimizationResultInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Optimizer\OptimizerInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Repository\ImageOptimizationResultRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ImageOptimizationResultPersister implements ImageOptimizationResultPersisterInterface
{
    /**
     * @var FactoryInterface
     */
    private $imageOptimizationResultFactory;

    /**
     * @var ImageOptimizationResultRepository
     */
    private $imageOptimizationResultRepository;

    public function __construct(FactoryInterface $imageOptimizationResultFactory, ImageOptimizationResultRepository $imageOptimizationResultRepository)
    {
        $this->imageOptimizationResultFactory = $imageOptimizationResultFactory;
        $this->imageOptimizationResultRepository = $imageOptimizationResultRepository;
    }

    /**
     * {@inheritdoc}
     *
     * @throws NonUniqueResultException
     */
    public function persist(AggregateOptimizationResultInterface $aggregateOptimizationResult, OptimizerInterface $optimizer): void
    {
        $imageOptimizationResult = $this->imageOptimizationResultRepository->findOneByOptimizer($optimizer->getCode());

        if (!$imageOptimizationResult) {
            /** @var ImageOptimizationResult $imageOptimizationResult */
            $imageOptimizationResult = $this->imageOptimizationResultFactory->createNew();
            $imageOptimizationResult->setOptimizer($optimizer);
        }

        $imageOptimizationResult->addOptimizedBytes($aggregateOptimizationResult->getOptimizedFileSize());
        $imageOptimizationResult->addOriginalBytes($aggregateOptimizationResult->getOriginalFileSize());

        $this->imageOptimizationResultRepository->add($imageOptimizationResult);
    }
}
