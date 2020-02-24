<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;

class Savings implements SavingsInterface
{
    use TimestampableTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $imageResource;

    /** @var int */
    protected $originalSize = 0;

    /** @var int */
    protected $optimizedSize = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function getImageResource(): string
    {
        return $this->imageResource;
    }

    public function setImageResource(string $imageResource): void
    {
        $this->imageResource = $imageResource;
    }

    public function getOriginalSize(): int
    {
        return $this->originalSize;
    }

    public function setOriginalSize(int $originalSize): void
    {
        $this->originalSize = $originalSize;
    }

    public function getOptimizedSize(): int
    {
        return $this->optimizedSize;
    }

    public function setOptimizedSize(int $optimizedSize): void
    {
        $this->optimizedSize = $optimizedSize;
    }

    public function getSaved(): int
    {
        return $this->getOriginalSize() - $this->getOptimizedSize();
    }
}
