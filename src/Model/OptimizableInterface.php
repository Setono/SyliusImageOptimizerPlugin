<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Model;

interface OptimizableInterface
{
    public function isOptimized(): bool;

    public function setOptimized(bool $optimized = true): void;
}
