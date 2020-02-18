<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer\Kraken;

use Kraken;
use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;
use Setono\SyliusImageOptimizerPlugin\Optimizer\WebPOptimizerInterface;

final class KrakenOptimizer implements WebPOptimizerInterface
{
    /** @var Kraken */
    private $kraken;

    public function __construct(Kraken $kraken)
    {
        $this->kraken = $kraken;
    }

    public function optimize(ImageFile $imageFile): OptimizationResultInterface
    {
        return $this->_optimize($imageFile, false);
    }

    public function optimizeAndConvertToWebP(ImageFile $imageFile): OptimizationResultInterface
    {
        return $this->_optimize($imageFile, true);
    }

    private function _optimize(ImageFile $imageFile, bool $webP): OptimizationResultInterface
    {
        $params = [
            'url' => $imageFile->getUrl(),
            'wait' => true,
            'lossy' => true,
        ];

        if ($webP) {
            $params['webp'] = true;
        }

        $data = $this->kraken->url($params);

        return KrakenOptimizationResult::createFromResponse($data, $webP);
    }
}
