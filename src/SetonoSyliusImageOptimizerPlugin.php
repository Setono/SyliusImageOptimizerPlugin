<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin;

use Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler\ConfigureNgrokAwareImageFileFactoryPass;
use Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler\ResolversCompilerPass;
use Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler\ValidateFilterSetsPass;
use Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler\ValidateImageResourcesPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SetonoSyliusImageOptimizerPlugin extends AbstractResourceBundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ValidateImageResourcesPass());
        $container->addCompilerPass(new ValidateFilterSetsPass());
        $container->addCompilerPass(new ConfigureNgrokAwareImageFileFactoryPass());
        $container->addCompilerPass(new ResolversCompilerPass());
    }

    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }
}
