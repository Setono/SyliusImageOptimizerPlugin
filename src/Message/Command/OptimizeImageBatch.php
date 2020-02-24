<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Command;

use Setono\DoctrineORMBatcher\Batch\BatchInterface;

final class OptimizeImageBatch implements CommandInterface
{
    /** @var string */
    private $imageResource;

    /** @var BatchInterface */
    private $batch;

    /** @var array */
    private $filterSets;

    public function __construct(string $imageResource, BatchInterface $batch, array $filterSets)
    {
        $this->imageResource = $imageResource;
        $this->batch = $batch;
        $this->filterSets = $filterSets;
    }

    public function getImageResource(): string
    {
        return $this->imageResource;
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
