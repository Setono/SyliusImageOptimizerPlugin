<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusImageOptimizerPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusImageOptimizerPlugin\DependencyInjection\SetonoSyliusImageOptimizerExtension;

final class SetonoSyliusImageOptimizerExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [new SetonoSyliusImageOptimizerExtension()];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameters_has_been_set()
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono.sylius_optimize_images.resources', []);
        $this->assertContainerBuilderHasParameter('setono.sylius_optimize_images.filter_sets', []);
    }
}
