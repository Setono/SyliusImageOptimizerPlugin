<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Writer;

use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;

interface OptimizedImageWriterInterface
{
    /**
     * @param string $path The path (in liip imagine context) where the image should be saved
     * @param string $filter The filter (also in liip context) which is used to deduce the real path for the image file
     * @param bool $removeSource If true, the method will delete the optimized image file when the file is written using liip imagine
     */
    public function write(OptimizationResultInterface $optimizationResult, string $path, string $filter, bool $removeSource = true): void;
}
