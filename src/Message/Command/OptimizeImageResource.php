<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Command;

final class OptimizeImageResource implements CommandInterface
{
    /** @var string */
    private $imageResource;

    /** @var array */
    private $filterSets;

    public function __construct(string $imageResource, array $filterSets)
    {
        $this->imageResource = $imageResource;
        $this->filterSets = $filterSets;
    }

    public function getImageResource(): string
    {
        return $this->imageResource;
    }

    public function getFilterSets(): array
    {
        return $this->filterSets;
    }
}
