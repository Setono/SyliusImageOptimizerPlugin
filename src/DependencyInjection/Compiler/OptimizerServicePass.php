<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\DependencyInjection\Compiler;

use Loevgaard\SyliusOptimizeImagesPlugin\Command\OptimizeCommand;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class OptimizerServicePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $taggedOptimizers = $container->findTaggedServiceIds('loevgaard.sylius_optimize_images.optimizer');

        $commandDefinition = new Definition(OptimizeCommand::class);
        $commandDefinition->addTag('console.command');

        foreach ($taggedOptimizers as $id => $tags) {
            $commandDefinition->addArgument(new Reference($id));
        }

        $container->setDefinition('loevgaard.sylius_optimize_images.command.optimize', $commandDefinition);
    }
}
