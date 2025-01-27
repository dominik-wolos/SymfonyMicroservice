<?php

declare(strict_types=1);

namespace App\Components\Task\Repository;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Entity\Task;
use App\Components\Task\Entity\TaskInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findOneByIdAndPlayer(int $id, PlayerInterface $player): ?TaskInterface
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->andWhere('s.player = :player')
            ->setParameter('id', $id)
            ->setParameter('player', $player)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findTodaysChallengeTaskByPlayer(PlayerInterface $player): ?TaskInterface
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.player = :player')
            ->andWhere('s.startsAt LIKE :date')
            ->andWhere('s.type = :type')
            ->setParameter('date', (new \DateTime('today'))->format('Y-m-d') . '%')
            ->setParameter('player', $player)
            ->setParameter('type', TaskInterface::CHALLENGE)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
