<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Resolver;

use Sylius\Component\Resource\Metadata\MetadataInterface;

interface ResourcesResolverInterface
{
    /**
     * Will resolve an array of resources based on the plugin config
     *
     * If the config doesn't contain resources, this will return all resources implementing the Sylius\Component\Core\Model\ImageInterface
     *
     * @return MetadataInterface[]
     */
    public function resolveResources(): array;
}
