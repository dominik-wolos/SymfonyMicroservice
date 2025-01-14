<?php

declare(strict_types=1);

namespace App\Components\Challenge\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        "get_today_challenge" => [
            'method' => 'GET',
            'path' => '/daily_challenge/today',
            'controller' => '\App\Core\Controller\ChallengeController::getTodayChallenge',
            'openapi_context' => [
                'summary' => 'Get today challenge',
                'description' => 'Get today challenge',
            ],
        ],
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
)]
#[ORM\Entity(repositoryClass: 'App\Components\Challenge\Repository\DailyChallengeRepository')]
#[ORM\Table(name: 'daily_challenge')]
final class DailyChallenge implements DailyChallengeInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Challenge::class)]
    private Challenge $challenge;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $date;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getChallenge(): Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(Challenge $challenge): void
    {
        $this->challenge = $challenge;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }
}
