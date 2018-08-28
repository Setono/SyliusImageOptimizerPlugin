<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult;

interface AggregateOptimizationResultInterface
{
    /**
     * Returns the total file size in bytes of all the original files
     *
     * @return int
     */
    public function getOriginalFileSize(): int;

    /**
     * Returns the total file size in bytes of all the optimized files
     *
     * @return int
     */
    public function getOptimizedFileSize(): int;
}
