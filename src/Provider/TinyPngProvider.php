<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Provider;

use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\OptimizationResult;
use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\OptimizationResultInterface;

class TinyPngProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function optimize(\SplFileInfo $file): OptimizationResultInterface
    {
        $result = new OptimizationResult($file, $file);

        return $result;
    }
}
