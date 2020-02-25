<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface SavingsRepositoryInterface extends RepositoryInterface
{
    public function createSummedListQueryBuilder(): QueryBuilder;
}
