<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler;

use Setono\SyliusImageOptimizerPlugin\Factory\NgrokAwareImageFileFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class ConfigureNgrokAwareImageFileFactoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('kernel.environment') || !$container->hasParameter('kernel.debug')) {
            return;
        }

        if($container->getParameter('kernel.environment') !== 'dev' || $container->getParameter('kernel.debug') !== true) {
            return;
        }

        $definition = new Definition(NgrokAwareImageFileFactory::class);
    }
}
