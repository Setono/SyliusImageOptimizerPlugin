<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Doctrine\ORM;

use Setono\SyliusImageOptimizerPlugin\Repository\SavingsRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class SavingsRepository extends EntityRepository implements SavingsRepositoryInterface
{
}
