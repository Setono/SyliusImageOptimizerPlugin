<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer\Kraken;

use Kraken;
use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizerInterface;

final class KrakenOptimizer implements OptimizerInterface
{
    /** @var Kraken */
    private $kraken;

    public function __construct(Kraken $kraken)
    {
        $this->kraken = $kraken;
    }

    public function optimize(ImageFile $imageFile): OptimizationResultInterface
    {
        dump($imageFile->getUrl());
        $data = $this->kraken->url([
            'url' => $imageFile->getUrl(),
            'wait' => true,
            'lossy' => true,
            'webp' => true,
        ]);

        dump($data);

        return KrakenOptimizationResult::createFromResponse($data);
    }
}
