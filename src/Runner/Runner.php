<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Runner;

use Loevgaard\SyliusOptimizeImagesPlugin\Persister\ImageOptimizationResultPersisterInterface;

final class Runner implements RunnerInterface
{
    /**
     * @var ImageOptimizationResultPersisterInterface
     */
    private $imageOptimizationResultPersister;

    public function __construct(ImageOptimizationResultPersisterInterface $imageOptimizationResultPersister)
    {
        $this->imageOptimizationResultPersister = $imageOptimizationResultPersister;
    }

    public function run(): void
    {
    }
}
