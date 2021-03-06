<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Writer;

use InvalidArgumentException;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Model\FileBinary;
use RuntimeException;
use function Safe\sprintf;
use function Safe\unlink;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;
use Symfony\Component\Mime\MimeTypesInterface;

final class OptimizedImageWriter implements OptimizedImageWriterInterface
{
    /** @var CacheManager */
    private $cacheManager;

    /** @var MimeTypesInterface */
    private $mimeTypes;

    public function __construct(CacheManager $cacheManager, MimeTypesInterface $mimeTypes)
    {
        $this->cacheManager = $cacheManager;
        $this->mimeTypes = $mimeTypes;
    }

    public function write(OptimizationResultInterface $optimizationResult, string $path, string $filter, bool $removeSource = true): void
    {
        if ($optimizationResult->isWebP()) {
            $pathInfo = pathinfo($path);
            $path = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
        }

        $optimizedImageFile = $optimizationResult->getFile();

        if (!file_exists($optimizedImageFile)) {
            throw new InvalidArgumentException(sprintf('The file %s does not exist', $optimizedImageFile));
        }

        $mimeType = $this->mimeTypes->guessMimeType($optimizedImageFile);
        if (null === $mimeType) {
            throw new RuntimeException(sprintf('Could not deduce mime type from file %s', $optimizedImageFile));
        }

        $binary = new FileBinary($optimizedImageFile, $mimeType);

        $this->cacheManager->store($binary, $path, $filter);

        if ($removeSource) {
            unlink($optimizedImageFile);
        }
    }
}
