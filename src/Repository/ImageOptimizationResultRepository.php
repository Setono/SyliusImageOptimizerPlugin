<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Repository;

use Loevgaard\SyliusOptimizeImagesPlugin\Entity\ImageOptimizationResult;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ImageOptimizationResultRepository extends EntityRepository
{
    /**
     * @param string $optimizer
     *
     * @return ImageOptimizationResult|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByOptimizer(string $optimizer): ?ImageOptimizationResult
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.optimizer = :optimizer')
            ->setParameter('optimizer', $optimizer)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
