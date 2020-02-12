<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Runner;

use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\Resolver\ResolverInterface;
use Setono\SyliusImageOptimizerPlugin\Resolver\FilterSetsResolverInterface;
use Setono\SyliusImageOptimizerPlugin\Resolver\ResourcesResolverInterface;
use Setono\SyliusImageOptimizerPlugin\Storer\StorerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class Runner implements RunnerInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var ResourcesResolverInterface */
    private $resourcesResolver;

    /** @var FilterSetsResolverInterface */
    private $filterSetsResolver;

    /** @var ResolverInterface */
    private $cacheResolver;

    /** @var StorerInterface */
    private $storer;

    public function __construct(
        ContainerInterface $container,
        ResourcesResolverInterface $resourcesResolver,
        FilterSetsResolverInterface $filterSetsResolver,
        ResolverInterface $cacheResolver,
        StorerInterface $storer
    ) {
        $this->container = $container;
        $this->resourcesResolver = $resourcesResolver;
        $this->filterSetsResolver = $filterSetsResolver;
        $this->cacheResolver = $cacheResolver;
        $this->storer = $storer;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): void
    {
        $resources = $this->resourcesResolver->resolveResources();
        $filterSets = $this->filterSetsResolver->resolveFilterSets();

        foreach ($resources as $resource) {
            /** @var EntityManagerInterface $manager */
            $manager = $this->container->get($resource->getServiceId('manager'));

            $qb = $manager->createQueryBuilder();
            $qb->select('i.path')
                ->from($resource->getClass('model'), 'i'); // @todo it is not given that a path field will exist although it implements the Sylius Image Interface

            $paths = $qb->getQuery()->getResult();

            foreach ($paths as $path) {
                foreach ($filterSets as $filterSet) {
                    if ($this->cacheResolver->isStored($path, $filterSet)) {
                        continue;
                    }

                    $this->storer->store($path, $filterSet);
                }
            }
        }
    }
}
