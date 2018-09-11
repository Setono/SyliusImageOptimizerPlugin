<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

final class LoevgaardSyliusOptimizeImagesExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [new LoevgaardSyliusOptimizeImagesExtension()];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameters_has_been_set()
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('loevgaard.sylius_optimize_images.resources', []);
        $this->assertContainerBuilderHasParameter('loevgaard.sylius_optimize_images.filter_sets', []);
    }
}
