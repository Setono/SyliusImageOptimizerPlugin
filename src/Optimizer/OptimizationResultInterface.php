<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer;

use SplFileInfo;

interface OptimizationResultInterface
{
    /**
     * The original size in bytes
     */
    public function getOriginalSize(): int;

    /**
     * The optimized size in bytes
     */
    public function getOptimizedSize(): int;

    public function getSavedBytes(): int;

    public function getFile(): SplFileInfo;

    /**
     * @return bool Returns true if the file was converted in the optimization process
     */
    public function isWebP(): bool;
}
