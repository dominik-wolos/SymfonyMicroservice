<?php

declare(strict_types=1);

namespace App\Components\Statistic\Repository;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\Statistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class StatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statistic::class);
    }

    public function findStatisticsByIdsAndPlayer(array $ids, PlayerInterface $player): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id IN (:ids)')
            ->andWhere('s.playerStatistics = :playerStatistics')
            ->setParameter('ids', $ids)
            ->setParameter('playerStatistics', $player->getPlayerStatistics())
            ->getQuery()
            ->getResult();
    }
}
