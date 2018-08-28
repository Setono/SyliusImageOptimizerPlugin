<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult;

class OptimizationResult implements OptimizationResultInterface
{
    /**
     * @var \SplFileInfo
     */
    private $originalFile;

    /**
     * @var int
     */
    private $originalFileSize;

    /**
     * @var \SplFileInfo
     */
    private $optimizedFile;

    /**
     * @var int
     */
    private $optimizedFileSize;

    public function __construct(\SplFileInfo $originalFile, \SplFileInfo $optimizedFile)
    {
        $this->originalFile = $originalFile;
        $this->optimizedFile = $optimizedFile;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalFile(): \SplFileInfo
    {
        return $this->originalFile;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptimizedFile(): \SplFileInfo
    {
        return $this->optimizedFile;
    }

    /**
     * {@inheritdoc}
     */
    public function getSavedBytes(): int
    {
        return $this->getOriginalFileSize() - $this->getOptimizedFileSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getSavedPercent(): int
    {
        return (int) floor($this->getSavedBytes() / $this->getOriginalFileSize() * 100);
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalFileSize(): int
    {
        if (!$this->originalFileSize) {
            $this->originalFileSize = (int) filesize($this->getOriginalFile()->getPathname());
        }

        return $this->originalFileSize;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptimizedFileSize(): int
    {
        if (!$this->optimizedFileSize) {
            $this->optimizedFileSize = (int) filesize($this->getOptimizedFile()->getPathname());
        }

        return $this->optimizedFileSize;
    }
}
