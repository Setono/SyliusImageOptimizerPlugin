<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class LoevgaardSyliusOptimizeImagesExtension extends Extension implements PrependExtensionInterface
{
    const LIIP_IMAGINE_EXTENSION_NAME = 'liip_imagine';

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('loevgaard.sylius_optimize_images.resources', $config['resources']);
        $container->setParameter('loevgaard.sylius_optimize_images.filter_sets', $config['filter_sets']);

        $this->validateFilterSetsConfig($container, $config);

        $loader->load('services.xml');
    }

    /**
     * Validate the filter_sets config option
     *
     * @param ContainerBuilder $container
     * @param array $config
     *
     * @throws \Exception
     */
    private function validateFilterSetsConfig(ContainerBuilder $container, array $config): void
    {
        // if the filter_sets config is set we validate the filter sets against the available filter sets defined in the application
        if (!empty($config['filter_sets'])) {
            $availableFilterSets = $this->getAvailableFilterSets($container);

            foreach ($config['filter_sets'] as $filterSet) {
                if (!in_array($filterSet, $availableFilterSets)) {
                    throw new \Exception('The filter set "' . $filterSet . '" is not defined as a filter set in LiipImagineBundle. Add the filter set to the LiipImagineBundle config');
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $this->prependPostProcessor($container);
    }

    /**
     * This method adds the TinyPNG post processor to the enabled filter sets
     *
     * @param ContainerBuilder $container
     */
    private function prependPostProcessor(ContainerBuilder $container): void
    {
        $enabledFilterSets = $this->getEnabledFilterSets($container);

        $config = [
            'filter_sets' => [],
        ];

        foreach ($enabledFilterSets as $filterSet) {
            $config['filter_sets'][$filterSet] = [
                'post_processors' => [
                    'tiny_png_post_processor' => [],
                ],
            ];
        }

        $container->prependExtensionConfig(self::LIIP_IMAGINE_EXTENSION_NAME, $config);
    }

    /**
     * Return an array of filter sets that will have the post processor appended
     *
     * @param ContainerBuilder $container
     *
     * @return array
     */
    private function getEnabledFilterSets(ContainerBuilder $container): array
    {
        $filterSets = [];

        $config = $container->getExtensionConfig($this->getAlias());
        foreach ($config as $item) {
            if (!isset($item['filter_sets'])) {
                continue;
            }

            $filterSets = array_merge($filterSets, $item['filter_sets']);
        }

        // if no filter sets are defined in the config, use all filter sets defined in the LiipImagineBundle
        if (empty($filterSets)) {
            $filterSets = array_merge($filterSets, $this->getAvailableFilterSets($container));
        }

        return array_unique($filterSets);
    }

    /**
     * Returns the available filter set from the LiipImagineBundle config
     *
     * @param ContainerBuilder $container
     *
     * @return array
     */
    private function getAvailableFilterSets(ContainerBuilder $container): array
    {
        $filterSets = [];

        $config = $container->getExtensionConfig(self::LIIP_IMAGINE_EXTENSION_NAME);

        foreach ($config as $item) {
            if (!isset($item['filter_sets'])) {
                continue;
            }

            $filterSets = array_merge($filterSets, array_keys($item['filter_sets']));
        }

        return array_unique($filterSets);
    }
}
