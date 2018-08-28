<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Provider;

use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\OptimizationResult;
use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\OptimizationResultInterface;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class SpatieProvider extends Provider
{
    /**
     * {@inheritdoc}
     */
    public function optimize(\SplFileInfo $file): OptimizationResultInterface
    {
        $outputFile = $this->getTempFile();

        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize($file->getPathname(), $outputFile->getPathname());

        $result = new OptimizationResult($file, $outputFile);

        return $result;
    }
}
