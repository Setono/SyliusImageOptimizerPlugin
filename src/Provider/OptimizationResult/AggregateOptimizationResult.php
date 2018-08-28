<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Provider\OptimizationResult;

class AggregateOptimizationResult implements AggregateOptimizationResultInterface
{
    /**
     * @var OptimizationResultInterface[]
     */
    private $optimizationResults;

    public function __construct()
    {
        $this->optimizationResults = [];
    }

    public function addOptimizationResult(OptimizationResultInterface $optimizationResult): void
    {
        $this->optimizationResults[] = $optimizationResult;
    }

    /**
     * @inheritdoc
     */
    public function getOriginalFileSize(): int
    {
        $total = 0;

        foreach ($this->optimizationResults as $optimizationResult) {
            $total += $optimizationResult->getOriginalFileSize();
        }

        return $total;
    }

    /**
     * @inheritdoc
     */
    public function getOptimizedFileSize(): int
    {
        $total = 0;

        foreach ($this->optimizationResults as $optimizationResult) {
            $total += $optimizationResult->getOptimizedFileSize();
        }

        return $total;
    }
}
