<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Provider;

use Loevgaard\SyliusOptimizeImagesPlugin\Provider\OptimizationResult\OptimizationResultInterface;

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
