<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface SavingsInterface extends ResourceInterface, TimestampableInterface
{
    /**
     * The Sylius resource, i.e. sylius.product_image
     */
    public function getImageResource(): string;

    public function setImageResource(string $imageResource): void;

    /**
     * The original size in bytes
     */
    public function getOriginalSize(): int;

    public function setOriginalSize(int $originalSize): void;

    /**
     * The optimized size in bytes
     */
    public function getOptimizedSize(): int;

    public function setOptimizedSize(int $optimizedSize): void;

    /**
     * The number of bytes saved. Returns self::getOriginalSize() - self::getOptimizedSize()
     */
    public function getSaved(): int;
}
