<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Factory;

use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;

final class ImageFileFactory implements ImageFileFactoryInterface
{
    public function createFromUrl(string $url): ImageFile
    {
        return new ImageFile($url);
    }
}
