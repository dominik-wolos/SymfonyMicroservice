<?php

declare(strict_types=1);

namespace App\Components\Challenge\Repository;

use App\Components\Challenge\Entity\Challenge;
use App\Components\Challenge\Entity\ChallengeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ChallengeRepository extends ServiceEntityRepository implements ChallengeRepositoryInterface
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
        parent::__construct($this->registry, Challenge::class);
    }

    public function getRandomChallenge(): ChallengeInterface
    {
        $count = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $offset = random_int(0, $count - 1);

        return $this->createQueryBuilder('c')
            ->setMaxResults(1)
            ->setFirstResult($offset)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
