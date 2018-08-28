<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Runner;

use Loevgaard\SyliusOptimizeImagesPlugin\Manager\OptimizerManagerInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Persister\ImageOptimizationResultPersisterInterface;

final class Runner implements RunnerInterface
{
    /**
     * @var OptimizerManagerInterface
     */
    private $optimizerManager;

    /**
     * @var ImageOptimizationResultPersisterInterface
     */
    private $imageOptimizationResultPersister;

    public function __construct(OptimizerManagerInterface $optimizerManager, ImageOptimizationResultPersisterInterface $imageOptimizationResultPersister)
    {
        $this->optimizerManager = $optimizerManager;
        $this->imageOptimizationResultPersister = $imageOptimizationResultPersister;
    }

    public function run(): void
    {
        foreach ($this->optimizerManager->all() as $optimizer) {
            $aggregateOptimizationResult = $optimizer->optimize();

            $this->imageOptimizationResultPersister->persist($aggregateOptimizationResult, $optimizer);
        }
    }
}
