<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin;

use Loevgaard\SyliusOptimizeImagesPlugin\DependencyInjection\Compiler\OptimizerServicePass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class LoevgaardSyliusOptimizeImagesPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OptimizerServicePass());
    }
}
