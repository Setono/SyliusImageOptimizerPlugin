<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Model;

trait OptimizableTrait
{
    protected $optimized = false;

    public function isOptimized(): bool
    {
        return $this->optimized;
    }

    public function setOptimized(bool $optimized = true): void
    {
        $this->optimized = $optimized;
    }
}
