<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        if (method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('setono_sylius_image_optimizer');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('setono_sylius_image_optimizer');
        }

        $rootNode
            ->fixXmlConfig('connection')
            ->children()
                ->arrayNode('image_resources')
                    ->requiresAtLeastOneElement()
                    ->isRequired()
                    ->info('These are the image resources that will be optimized by the optimize command')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->isRequired()
                        ->requiresAtLeastOneElement()
                        ->validate()
                            ->ifTrue(static function (array $v) {
                                return count(array_unique($v)) !== count($v);
                            })
                            ->thenInvalid('The filter sets must be unique')
                        ->end()
                        ->scalarPrototype()->end()
                    ->end()
                ->end()
                ->arrayNode('kraken')
                    ->isRequired()
                    ->children()
                        ->scalarNode('key')
                            ->isRequired()
                        ->end()
                        ->scalarNode('secret')
                            ->isRequired()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
