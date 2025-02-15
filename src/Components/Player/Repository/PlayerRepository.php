<?php

declare(strict_types=1);

namespace App\Components\Player\Repository;

use App\Components\Player\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class PlayerRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findOneByEmail(string $email): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByVerificationCode(string $verificationCode): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.verificationCode = :verificationCode')
            ->setParameter('verificationCode', $verificationCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByToken(string $token): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.resetPasswordToken = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
