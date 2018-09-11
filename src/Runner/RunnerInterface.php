<?php

declare(strict_types=1);

namespace Setono\SyliusOptimizeImagesPlugin\Runner;

interface RunnerInterface
{
    /**
     * Will run the optimization of images
     */
    public function run(): void;
}
