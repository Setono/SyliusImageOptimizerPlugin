<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: loevgaard
 * Date: 28/08/2018
 * Time: 14.39
 */

namespace Loevgaard\SyliusOptimizeImagesPlugin\Manager;

use Loevgaard\SyliusOptimizeImagesPlugin\Optimizer\OptimizerInterface;

interface OptimizerManagerInterface
{
    /**
     * Returns all the optimizers
     *
     * @return OptimizerInterface[]
     */
    public function all(): array;

    /**
     * Returns the optimizer matching the code or null if it isn't found
     *
     * @param string $code
     *
     * @return OptimizerInterface|null
     */
    public function findByCode(string $code): ?OptimizerInterface;
}
