<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusImageOptimizerPlugin\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Setono\SyliusImageOptimizerPlugin\DependencyInjection\Configuration;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    /**
     * @test
     */
    public function values_are_invalid_if_required_value_is_not_provided(): void
    {
        $this->assertConfigurationIsInvalid(
            [
                [], // no values at all
            ],
            'The child node "image_resources" at path "setono_sylius_image_optimizer" must be configured.'
        );
    }

    /**
     * @test
     */
    public function processed_value_contains_required_value(): void
    {
        $this->assertProcessedConfigurationEquals([
            [
                'image_resources' => [
                    'sylius.product_image' => [
                        'sylius_shop_product_original',
                    ],
                ],
                'kraken' => [
                    'key' => 'key',
                    'secret' => 'secret',
                ],
            ],
            [
                'kraken' => [
                    'key' => 'key2',
                    'secret' => 'secret2',
                ],
            ],
        ], [
            'image_resources' => [
                'sylius.product_image' => [
                    'sylius_shop_product_original',
                ],
            ],
            'kraken' => [
                'key' => 'key2',
                'secret' => 'secret2',
            ],
        ]);
    }
}
