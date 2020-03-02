<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler;

use Setono\SyliusImageOptimizerPlugin\Factory\NgrokAwareImageFileFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This compiler pass will allow you to test the plugin on your localhost by running ngrok (https://ngrok.com)
 * and pointing the tunnel to your localhost
 */
final class ConfigureNgrokAwareImageFileFactoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('kernel.environment') || !$container->hasParameter('kernel.debug')) {
            return;
        }

        if ($container->getParameter('kernel.environment') !== 'dev' || $container->getParameter('kernel.debug') !== true) {
            return;
        }

        if(!$container->hasDefinition('logger')) {
            return;
        }

        if(!$container->hasDefinition('http_client')) {
            throw new ServiceNotFoundException('http_client', null, null, [], 'Run composer require --dev symfony/http-client to fix this');
        }

        $definition = new Definition(NgrokAwareImageFileFactory::class, [
            new Reference('setono_sylius_image_optimizer.factory.ngrok_aware_image_file.inner'),
            new Reference('http_client'),
            new Reference('logger'),
        ]);
        $definition->setDecoratedService('setono_sylius_image_optimizer.factory.image_file');

        $container->setDefinition('setono_sylius_image_optimizer.factory.ngrok_aware_image_file', $definition);
    }
}
