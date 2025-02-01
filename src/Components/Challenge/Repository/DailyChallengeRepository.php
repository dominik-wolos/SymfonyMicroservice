<?php

declare(strict_types=1);

namespace App\Components\Challenge\Repository;

use App\Components\Challenge\Entity\DailyChallenge;
use App\Components\Challenge\Entity\DailyChallengeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DailyChallengeRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
        parent::__construct($this->registry, DailyChallenge::class);
    }

    public function getTodaysChallenge(): ?DailyChallengeInterface
    {
        return $this->createQueryBuilder('dc')
            ->andWhere('dc.date LIKE :date')
            ->setParameter('date', (new \DateTime('today'))->format('Y-m-d') . '%')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
