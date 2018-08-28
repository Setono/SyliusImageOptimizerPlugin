<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\DependencyInjection;

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
            ->children()
                ->scalarNode('provider')
                    ->cannotBeEmpty()
                    ->defaultValue('loevgaard.sylius_optimize_images.provider.spatie')
                    ->info('The service name of the provider you want to use')
                ->end()
                ->booleanNode('backup')
                    ->defaultTrue()
                    ->info('If this is true, backups are saved in media/image_backup')
                ->end()
                ->scalarNode('backup_dir')
                    ->defaultValue('%kernel.project_dir%/web/media/image_backup')
                    ->info('The directory where backups are saved')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
