<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer\Kraken;

use Kraken;
use RuntimeException;
use function Safe\sprintf;
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

        if (!isset($data['success']) || $data['success'] !== true) {
            throw new RuntimeException(sprintf(
                'An error occurred during the optimization of the image file: %s. Error was: %s',
                $imageFile->getUrl(), $data['error'] ?? 'Empty'
            ));
        }

        return KrakenOptimizationResult::createFromResponse($data, $webP);
    }
}
