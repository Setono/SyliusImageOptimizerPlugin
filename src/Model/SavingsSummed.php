<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Model;

final class SavingsSummed
{
    /** @var string */
    private $imageResource;

    /** @var int */
    private $originalSize = 0;

    /** @var int */
    private $optimizedSize = 0;

    public function __construct(string $imageResource, int $originalSize, int $optimizedSize)
    {
        $this->imageResource = $imageResource;
        $this->originalSize = $originalSize;
        $this->optimizedSize = $optimizedSize;
    }

    public function getImageResource(): string
    {
        return $this->imageResource;
    }

    public function getOriginalSize(): int
    {
        return $this->originalSize;
    }

    public function getOptimizedSize(): int
    {
        return $this->optimizedSize;
    }

    public function getSaved(): int
    {
        return $this->getOriginalSize() - $this->getOptimizedSize();
    }

    public function getPercentageSaved(): float
    {
        return $this->getSaved() / $this->getOriginalSize() * 100;
    }
}
