<?php

declare(strict_types=1);

namespace App\Components\Statistic\Repository;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\Statistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CategoryStatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statistic::class);
    }

    public function findExistingIdsByPlayer(array $ids, PlayerInterface $player): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.statistic')
            ->innerJoin('s.category', 'c')
            ->andWhere('s.statistic IN (:ids)')
            ->andWhere('c.player = :player')
            ->setParameter('ids', $ids)
            ->setParameter('player', $player)
            ->getQuery()
            ->getResult();
    }
}
