<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Resolver;

use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Sylius\Component\Resource\Metadata\RegistryInterface;

class ResourcesResolver implements ResourcesResolverInterface
{
    /** @var RegistryInterface */
    private $registry;

    /** @var array */
    private $resourcesConfig;

    /**
     * @param array $resourcesConfig The bundle's resources config
     */
    public function __construct(RegistryInterface $registry, array $resourcesConfig)
    {
        $this->registry = $registry;
        $this->resourcesConfig = $resourcesConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveResources(): array
    {
        $res = [];

        if (empty($this->resourcesConfig)) {
            // find all resources that implements the Sylius\Component\Core\Model\ImageInterface
            $resources = $this->registry->getAll();
            foreach ($resources as $resource) {
                if (!$this->implementsImageInterface($resource)) {
                    continue;
                }

                $res[] = $resource;
            }
        } else {
            // validate that all resources implement the interface Sylius\Component\Core\Model\ImageInterface
            foreach ($this->resourcesConfig as $item) {
                $resource = $this->registry->get($item);

                if (!$this->implementsImageInterface($resource)) {
                    continue;
                }

                $res[] = $resource;
            }
        }

        return $res;
    }

    /**
     * Returns true if the resource's model implements the interface Sylius\Component\Core\Model\ImageInterface
     */
    private function implementsImageInterface(MetadataInterface $resource): bool
    {
        return is_a($resource->getClass('model'), ImageInterface::class, true);
    }
}
