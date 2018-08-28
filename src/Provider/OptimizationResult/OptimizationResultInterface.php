<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Provider\OptimizationResult;


interface OptimizationResultInterface
{
    /**
     * Returns the original image file
     *
     * @return \SplFileInfo
     */
    public function getOriginalFile(): \SplFileInfo;

    /**
     * Returns the optimized version of the original image file
     *
     * @return \SplFileInfo
     */
    public function getOptimizedFile(): \SplFileInfo;

    /**
     * Returns the number of saved bytes in this optimization
     *
     * @return int
     */
    public function getSavedBytes(): int;

    /**
     * The percent saved in this optimization (rounded down)
     * I.e. original file size 100 KB, optimized file size 80 KB => saved percent = 20%
     *
     * @return int
     */
    public function getSavedPercent(): int;

    /**
     * Returns the file size in bytes of the original file
     *
     * @return int
     */
    public function getOriginalFileSize(): int;

    /**
     * Returns the file size in bytes of the optimized file
     *
     * @return int
     */
    public function getOptimizedFileSize(): int;
}
