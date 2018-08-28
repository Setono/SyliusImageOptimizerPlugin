<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Provider;

abstract class Provider implements ProviderInterface
{
    protected function getTempFile(): \SplFileInfo
    {
        do {
            $file = new \SplFileInfo(sys_get_temp_dir() . '/' . uniqid('optimized-', true));
        } while ($file->isFile());

        return $file;
    }
}
