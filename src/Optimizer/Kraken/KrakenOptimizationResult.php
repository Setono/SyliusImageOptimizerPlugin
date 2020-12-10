<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer\Kraken;

use function Safe\file_get_contents;
use Setono\Kraken\Client\Response\WaitResponse;
use Setono\SyliusImageOptimizerPlugin\Optimizer\OptimizationResultInterface;
use Webimpress\SafeWriter\FileWriter;

final class KrakenOptimizationResult implements OptimizationResultInterface
{
    /** @var string */
    private $file;

    /** @var int */
    private $originalSize;

    /** @var int */
    private $optimizedSize;

    /** @var string */
    private $url;

    /** @var bool */
    private $webP;

    private function __construct(int $originalSize, int $optimizedSize, string $url, bool $webP)
    {
        $this->originalSize = $originalSize;
        $this->optimizedSize = $optimizedSize;
        $this->url = $url;
        $this->webP = $webP;
    }

    public static function createFromResponse(WaitResponse $response, bool $webP): self
    {
        return new self($response->getOriginalSize(), $response->getKrakedSize(), $response->getKrakedUrl(), $webP);
    }

    public function getOriginalSize(): int
    {
        return $this->originalSize;
    }

    public function getOptimizedSize(): int
    {
        return $this->optimizedSize;
    }

    public function getSavedBytes(): int
    {
        return $this->getOriginalSize() - $this->getOptimizedSize();
    }

    public function getFile(): string
    {
        if (null === $this->file) {
            do {
                $filename = sys_get_temp_dir() . '/' . uniqid('optimized-image-file-', true);
            } while (file_exists($filename));

            FileWriter::writeFile($filename, file_get_contents($this->url));

            $this->file = $filename;
        }

        return $this->file;
    }

    public function isWebP(): bool
    {
        return $this->webP;
    }
}
