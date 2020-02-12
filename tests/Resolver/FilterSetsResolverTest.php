<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusImageOptimizerPlugin\Resolver;

use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Setono\SyliusImageOptimizerPlugin\Resolver\FilterSetsResolver;

class FilterSetsResolverTest extends TestCase
{
    /**
     * @test
     */
    public function resolveReturnsAvailableFilterSets(): void
    {
        $resolver = new FilterSetsResolver($this->getFilterConfiguration(), []);
        $filters = $resolver->resolveFilterSets();

        $this->assertSame(['filter1', 'filter2'], $filters);
    }

    /**
     * @test
     */
    public function resolveReturnsConfiguredFilterSets(): void
    {
        $resolver = new FilterSetsResolver($this->getFilterConfiguration(), ['filter1']);
        $filters = $resolver->resolveFilterSets();

        $this->assertSame(['filter1'], $filters);
    }

    /**
     * @test
     */
    public function resolveReturnsConfiguredFilterSetsIfTheyExist(): void
    {
        $resolver = new FilterSetsResolver($this->getFilterConfiguration(), ['filter1', 'filter3']);
        $filters = $resolver->resolveFilterSets();

        $this->assertSame(['filter1'], $filters);
    }

    /**
     * @return MockObject|FilterConfiguration
     */
    private function getFilterConfiguration(): MockObject
    {
        $filterConfiguration = $this->getMockBuilder(FilterConfiguration::class)->getMock();
        $filterConfiguration->method('all')->willReturn(['filter1' => [], 'filter2' => []]);

        return $filterConfiguration;
    }
}
