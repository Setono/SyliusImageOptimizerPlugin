<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Provider;

use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\OptimizationResultInterface;

interface ProviderInterface
{
    /**
     * Will optimize the given file
     *
     * @param \SplFileInfo $file
     *
     * @return OptimizationResultInterface
     */
    public function optimize(\SplFileInfo $file): OptimizationResultInterface;
}
