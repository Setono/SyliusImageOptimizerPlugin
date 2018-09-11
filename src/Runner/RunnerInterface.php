<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Runner;

interface RunnerInterface
{
    /**
     * Will run the optimization of images
     */
    public function run(): void;
}
