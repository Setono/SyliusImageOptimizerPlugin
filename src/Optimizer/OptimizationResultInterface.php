<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer;

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

    /**
     * Returns the absolute path to the file
     */
    public function getFile(): string;

    /**
     * @return bool Returns true if the file was converted in the optimization process
     */
    public function isWebP(): bool;
}
