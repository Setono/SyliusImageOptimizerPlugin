<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer;

use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;

interface OptimizerInterface
{
    /**
     * Will optimize the given image file
     */
    public function optimize(ImageFile $imageFile): OptimizationResultInterface;
}
