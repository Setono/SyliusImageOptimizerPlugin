<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer\Kraken;

use Setono\Kraken\Client\ClientInterface;
use Setono\Kraken\Client\Response\WaitResponse;
use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;
use Setono\SyliusImageOptimizerPlugin\Optimizer\WebPOptimizerInterface;

final class KrakenOptimizer implements WebPOptimizerInterface
{
    /** @var ClientInterface */
    private $kraken;

    public function __construct(ClientInterface $kraken)
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
        $extra = [];
        if ($webP) {
            $extra['webp'] = true;
        }

        /** @var WaitResponse $response */
        $response = $this->kraken->url($imageFile->getUrl(), true, true, $extra);

        return KrakenOptimizationResult::createFromResponse($response, $webP);
    }
}
