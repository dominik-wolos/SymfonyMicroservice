<?php

declare(strict_types=1);

namespace App\Components\Shop\Repository;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Shop\Entity\Augment;
use App\Components\Shop\Entity\AugmentInterface;
use App\Components\Shop\Enum\AugmentTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

final class AugmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Augment::class);
    }

    public function createAllActiveByPlayerQueryBuilder(PlayerInterface $player): QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.player = :player')
            ->andWhere('s.endsAt > :date')
            ->setParameter('player', $player)
            ->setParameter('date', new \DateTime())
        ;
    }

    public function findActiveAugmentByPlayerAndTypeAndCategory(
        PlayerInterface $player,
        string $type,
        CategoryInterface $category,
    ): ?AugmentInterface {
        return $this->createAllActiveByPlayerQueryBuilder($player)
            ->innerJoin('s.category', 'c')
            ->andWhere('s.type = :type')
            ->andWhere('c = :category')
            ->setParameter('category', $category)
            ->setParameter('type', $type)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
