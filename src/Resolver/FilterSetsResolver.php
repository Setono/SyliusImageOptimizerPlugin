<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Resolver;

use Liip\ImagineBundle\Imagine\Filter\FilterManager;

class FilterSetsResolver implements FilterSetsResolverInterface
{
    /**
     * @var FilterManager
     */
    private $filterManager;

    /**
     * @var string[]
     */
    private $filterSetsConfig;

    /**
     * @param FilterManager $filterManager
     * @param array $filterSetsConfig The bundle's filter set config
     */
    public function __construct(FilterManager $filterManager, array $filterSetsConfig)
    {
        $this->filterManager = $filterManager;
        $this->filterSetsConfig = $filterSetsConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveFilterSets(): array
    {
        $availableFilterSets = array_keys($this->filterManager->getFilterConfiguration()->all());

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
