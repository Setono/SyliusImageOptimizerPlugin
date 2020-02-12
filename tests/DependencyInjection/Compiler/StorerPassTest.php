<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class StorerPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new StorerPass());
    }
}
