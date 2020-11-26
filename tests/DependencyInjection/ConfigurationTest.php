<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusImageOptimizerPlugin\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Setono\SyliusImageOptimizerPlugin\DependencyInjection\Configuration;
use Setono\SyliusImageOptimizerPlugin\Doctrine\ORM\SavingsRepository;
use Setono\SyliusImageOptimizerPlugin\Model\Savings;
use Setono\SyliusImageOptimizerPlugin\Model\SavingsInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Form\Type\DefaultResourceType;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;

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
            ],
            [
                'image_resources' => [
                    'sylius.product_image' => [
                        'sylius_shop_product_large_thumbnail',
                    ],
                ],
            ],
        ], [
            'image_resources' => [
                'sylius.product_image' => [
                    'sylius_shop_product_original',
                    'sylius_shop_product_large_thumbnail',
                ],
            ],
            'driver' => SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
            'resources' => [
                'savings' => [
                    'classes' => [
                        'model' => Savings::class,
                        'controller' => ResourceController::class,
                        'repository' => SavingsRepository::class,
                        'form' => DefaultResourceType::class,
                        'factory' => Factory::class,
                    ],
                ],
            ],
        ]);
    }
}
