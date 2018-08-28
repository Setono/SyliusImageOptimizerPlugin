<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Optimizer;

use Loevgaard\SyliusOptimizeImagesPlugin\Provider\OptimizationResult\AggregateOptimizationResultInterface;

interface OptimizerInterface
{
    public function optimize(): AggregateOptimizationResultInterface;
}
