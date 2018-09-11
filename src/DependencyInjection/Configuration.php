<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\DependencyInjection;

use Sylius\Component\Core\Model\ImageInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('loevgaard_sylius_optimize_images');
        $rootNode
            ->fixXmlConfig('filter_set')
            ->fixXmlConfig('resource')
            ->children()
                ->arrayNode('filter_sets')
                    ->scalarPrototype()->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('resources')
                    ->scalarPrototype()->end()
                    ->info('The resource must implement the interface ' . ImageInterface::class)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
