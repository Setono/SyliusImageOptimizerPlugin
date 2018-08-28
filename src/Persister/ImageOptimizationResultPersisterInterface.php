<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Persister;

use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\AggregateOptimizationResultInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Optimizer\OptimizerInterface;

interface ImageOptimizationResultPersisterInterface
{
    /**
     * Will save the result to the database
     *
     * @param AggregateOptimizationResultInterface $aggregateOptimizationResult
     * @param OptimizerInterface $optimizer
     */
    public function persist(
        AggregateOptimizationResultInterface $aggregateOptimizationResult,
        OptimizerInterface $optimizer
    ): void;
}
