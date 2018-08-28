<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Resolver;

interface PathResolverInterface
{
    /**
     * Must resolve an absolute path based on the given (relative) path and filter
     *
     * @param string $path
     * @param string $filter
     *
     * @return string
     */
    public function resolve(string $path, string $filter): string;
}
