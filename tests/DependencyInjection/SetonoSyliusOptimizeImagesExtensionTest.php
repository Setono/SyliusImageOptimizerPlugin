<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusOptimizeImagesPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusOptimizeImagesPlugin\DependencyInjection\SetonoSyliusOptimizeImagesExtension;

final class SetonoSyliusOptimizeImagesExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [new SetonoSyliusOptimizeImagesExtension()];
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
