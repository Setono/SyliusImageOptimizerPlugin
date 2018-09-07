<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Resolver;

interface FilterSetsResolverInterface
{
    /**
     * Will resolve an array of resources based on the plugin config
     *
     * If the config doesn't contain filter sets, this will return all filter sets from the filter configuration
     *
     * @return string[]
     */
    public function resolveFilterSets(): array;
}
