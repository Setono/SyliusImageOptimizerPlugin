<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusImageOptimizerPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusImageOptimizerPlugin\DependencyInjection\SetonoSyliusImageOptimizerExtension;

final class SetonoSyliusImageOptimizerExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new SetonoSyliusImageOptimizerExtension()];
    }

    protected function getMinimalConfiguration(): array
    {
        return [
            'image_resources' => [
                'sylius.product_image' => [
                    'sylius_shop_product_original',
                ],
            ],
            'kraken' => [
                'key' => 'key',
                'secret' => 'secret',
            ],
        ];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameters_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_sylius_image_optimizer.image_resources', [
            'sylius.product_image' => [
                'sylius_shop_product_original',
            ],
        ]);

        $this->assertContainerBuilderHasParameter('setono_sylius_image_optimizer.kraken.key', 'key');
        $this->assertContainerBuilderHasParameter('setono_sylius_image_optimizer.kraken.secret', 'secret');
    }
}
