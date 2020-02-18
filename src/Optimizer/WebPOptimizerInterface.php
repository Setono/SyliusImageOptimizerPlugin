<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer;

use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;

interface WebPOptimizerInterface extends OptimizerInterface
{
    /**
     * Will optimize the given image file and convert it to webp
     */
    public function optimizeAndConvertToWebP(ImageFile $imageFile): OptimizationResultInterface;
}
