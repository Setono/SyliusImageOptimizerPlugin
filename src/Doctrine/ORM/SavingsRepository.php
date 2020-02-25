<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Setono\SyliusImageOptimizerPlugin\Repository\SavingsRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class SavingsRepository extends EntityRepository implements SavingsRepositoryInterface
{
    public function createSummedListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->select('NEW Setono\SyliusImageOptimizerPlugin\Model\SavingsSummed(o.imageResource, SUM(o.originalSize), SUM(o.optimizedSize))')
            ->groupBy('o.imageResource')
        ;
    }
}
