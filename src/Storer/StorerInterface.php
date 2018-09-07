<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Storer;

interface StorerInterface
{
    /**
     * Takes care of the storage of the given path with the given filter
     *
     * @param string $path
     * @param string $filter
     */
    public function store(string $path, string $filter): void;
}
