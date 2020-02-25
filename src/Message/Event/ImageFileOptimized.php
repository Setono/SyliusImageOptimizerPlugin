<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Event;

use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;

final class ImageFileOptimized implements EventInterface
{
    /** @var string */
    private $imageResource;

    /** @var ImageFile */
    private $imageFile;

    /** @var OptimizationResultInterface */
    private $optimizationResult;

    public function __construct(string $imageResource, ImageFile $imageFile, OptimizationResultInterface $optimizationResult)
    {
        $this->imageResource = $imageResource;
        $this->imageFile = $imageFile;
        $this->optimizationResult = $optimizationResult;
    }

    public function getImageResource(): string
    {
        return $this->imageResource;
    }

    public function getImageFile(): ImageFile
    {
        return $this->imageFile;
    }

    public function getOptimizationResult(): OptimizationResultInterface
    {
        return $this->optimizationResult;
    }
}
