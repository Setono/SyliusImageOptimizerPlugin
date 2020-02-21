<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler;

use InvalidArgumentException;
use function Safe\sprintf;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ValidateImageResourcesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('sylius.resources')) {
            return;
        }

        $configuredImageResources = $container->getParameter('setono_sylius_image_optimizer.image_resources');
        $configuredResources = $container->getParameter('sylius.resources');

        foreach ($configuredImageResources as $imageResource => $filterSets) {
            if (!isset($configuredResources[$imageResource])) {
                throw new InvalidArgumentException(sprintf(
                    'The image resource "%s" is not a defined resource', $imageResource
                ));
            }

            $resource = $configuredResources[$imageResource];
            $class = $resource['classes']['model'];

            if (!is_a($class, ImageInterface::class, true)) {
                throw new InvalidArgumentException(sprintf(
                    'The resource "%s" you have defined as an image resource is not an instance of %s',
                    $imageResource, ImageInterface::class
                ));
            }

            if (!is_a($class, OptimizableInterface::class, true)) {
                throw new InvalidArgumentException(sprintf(
                    'The resource "%s" you have defined as an image resource is not an instance of %s',
                    $imageResource, OptimizableInterface::class
                ));
            }
        }
    }
}
