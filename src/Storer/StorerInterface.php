<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Storer;

interface StorerInterface
{
    /**
     * Takes care of the storage of the given path with the given filter
     */
    public function store(string $path, string $filter): void;
}
