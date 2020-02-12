<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin;

use Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler\StorerPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoSyliusImageOptimizerPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new StorerPass());
    }
}
