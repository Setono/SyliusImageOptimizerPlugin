<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Optimizer;

use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\AggregateOptimizationResultInterface;

interface OptimizerInterface
{
    /**
     * @return AggregateOptimizationResultInterface
     */
    public function optimize(): AggregateOptimizationResultInterface;

    /**
     * Returns a unique code for this optimizer
     *
     * @return string
     */
    public function getCode(): string;
}
