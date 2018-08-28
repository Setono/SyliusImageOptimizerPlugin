<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Manager;

use Loevgaard\SyliusOptimizeImagesPlugin\Optimizer\OptimizerInterface;

class OptimizerManager implements OptimizerManagerInterface
{
    /**
     * @var OptimizerInterface[]
     */
    private $optimizers;

    public function __construct(OptimizerInterface ...$optimizers)
    {
        $this->optimizers = $optimizers;
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->optimizers;
    }

    /**
     * {@inheritdoc}
     */
    public function findByCode(string $code): ?OptimizerInterface
    {
        foreach ($this->optimizers as $optimizer) {
            if ($optimizer->getCode() === $code) {
                return $optimizer;
            }
        }

        return null;
    }
}
