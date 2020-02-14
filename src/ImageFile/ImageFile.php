<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\ImageFile;

final class ImageFile
{
    /** @var string */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
