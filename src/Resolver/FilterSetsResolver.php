<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Resolver;

use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;

class FilterSetsResolver implements FilterSetsResolverInterface
{
    /**
     * @var FilterConfiguration
     */
    private $filterConfiguration;

    /**
     * @var string[]
     */
    private $filterSetsConfig;

    /**
     * @param FilterConfiguration $filterConfiguration
     * @param array $filterSetsConfig The bundle's filter set config
     */
    public function __construct(FilterConfiguration $filterConfiguration, array $filterSetsConfig)
    {
        $this->filterConfiguration = $filterConfiguration;
        $this->filterSetsConfig = $filterSetsConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveFilterSets(): array
    {
        $availableFilterSets = array_keys($this->filterConfiguration->all());

        if (empty($this->filterSetsConfig)) {
            return $availableFilterSets;
        }
        $res = [];

        // validate that all filter sets are in the filter configuration
        foreach ($this->filterSetsConfig as $item) {
            if (!in_array($item, $availableFilterSets)) {
                continue;
            }

            $res[] = $item;
        }

        return $res;
    }
}
