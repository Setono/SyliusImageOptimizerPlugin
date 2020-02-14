<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler;

use InvalidArgumentException;
use function Safe\sprintf;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ValidateFilterSetsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('liip_imagine.filter_sets')) {
            return;
        }

        $configuredFilterSets = $container->getParameter('liip_imagine.filter_sets');
        $configuredImageResources = $container->getParameter('setono.sylius_image_optimizer.image_resources');

        foreach ($configuredImageResources as $imageResource => $filterSets) {
            foreach ($filterSets as $filterSet) {
                if (!isset($configuredFilterSets[$filterSet])) {
                    throw new InvalidArgumentException(sprintf(
                        'The filter set "%s" defined on the image resource "%s" is not a valid filter set',
                        $filterSet, $imageResource
                    ));
                }
            }
        }
    }
}
