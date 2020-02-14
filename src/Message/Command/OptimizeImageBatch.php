<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Command;

use Setono\DoctrineORMBatcher\Batch\BatchInterface;

final class OptimizeImageBatch implements CommandInterface
{
    /** @var BatchInterface */
    private $batch;

    /** @var array */
    private $filterSets;

    public function __construct(BatchInterface $batch, array $filterSets)
    {
        $this->batch = $batch;
        $this->filterSets = $filterSets;
    }

    public function getBatch(): BatchInterface
    {
        return $this->batch;
    }

    public function getFilterSets(): array
    {
        return $this->filterSets;
    }
}
