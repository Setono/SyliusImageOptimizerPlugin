<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer\Kraken;

use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;

final class KrakenOptimizationResult implements OptimizationResultInterface
{
    /** @var int */
    private $originalSize;

    /** @var int */
    private $optimizedSize;

    private function __construct(int $originalSize, int $optimizedSize)
    {
        $this->originalSize = $originalSize;
        $this->optimizedSize = $optimizedSize;
    }

    public static function createFromResponse(array $response): self
    {
        return new self($response['original_size'], $response['kraked_size']);
    }

    public function getOriginalSize(): int
    {
        return $this->originalSize;
    }

    public function getOptimizedSize(): int
    {
        return $this->optimizedSize;
    }

    public function getSavedBytes(): int
    {
        return $this->getOriginalSize() - $this->getOptimizedSize();
    }
}
