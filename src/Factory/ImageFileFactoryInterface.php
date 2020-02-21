<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Factory;

use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;

interface ImageFileFactoryInterface
{
    public function createFromUrl(string $url): ImageFile;
}
