<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Storer;

use Liip\ImagineBundle\Service\FilterService;

class SyncStorer implements StorerInterface
{
    /** @var FilterService */
    private $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * {@inheritdoc}
     */
    public function store(string $path, string $filter): void
    {
        $this->filterService->getUrlOfFilteredImage($path, $filter);
    }
}
