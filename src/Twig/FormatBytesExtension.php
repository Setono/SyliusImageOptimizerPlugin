<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Twig;

use function Safe\sprintf;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class FormatBytesExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('setono_sylius_image_optimizer_format_bytes', [$this, 'formatBytes']),
        ];
    }

    /**
     * Taken from here: http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
     */
    public function formatBytes(int $bytes): string
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((mb_strlen((string) $bytes) - 1) / 3);

        if (!isset($size[$factor])) {
            $size[$factor] = 'undefined';
        }

        return sprintf('%.2f', $bytes / 1024 ** $factor) . ' ' . $size[$factor];
    }
}
