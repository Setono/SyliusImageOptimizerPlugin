<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Optimizer;

use Symfony\Component\DependencyInjection\Container;

abstract class Optimizer implements OptimizerInterface
{
    /**
     * @return string
     *
     * @throws \ReflectionException
     */
    public function getCode(): string
    {
        $r = new \ReflectionClass(static::class);

        return Container::underscore($r->getShortName());
    }
}
