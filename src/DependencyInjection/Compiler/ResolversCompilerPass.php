<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler;

use function count;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This class is copied from \Liip\ImagineBundle\DependencyInjection\Compiler\ResolversCompilerPass
 * Somehow it doesn't work with that one
 */
final class ResolversCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_sylius_image_optimizer.cache_manager')) {
            return;
        }

        $tags = $container->findTaggedServiceIds('liip_imagine.cache.resolver');

        if (count($tags) > 0) {
            $manager = $container->getDefinition('setono_sylius_image_optimizer.cache_manager');

            foreach ($tags as $id => $tag) {
                $manager->addMethodCall('addResolver', [$tag[0]['resolver'], new Reference($id)]);
            }
        }
    }
}
