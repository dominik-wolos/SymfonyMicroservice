<?php

declare(strict_types=1);

namespace App\Components\Challenge\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Components\Challenge\Provider\DailyChallengeProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
            new Get(
                uriTemplate: '/daily_challenge',
                provider: DailyChallengeProvider::class,
                normalizationContext: [
                    'groups' => [
                        self::READ,
                        self::ITEM_READ
                    ]
                ]
            ),
        ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
)]
#[ORM\Entity(repositoryClass: 'App\Components\Challenge\Repository\DailyChallengeRepository')]
#[ORM\Table(name: 'daily_challenge')]
class DailyChallenge implements DailyChallengeInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups(self::ITEM_READ)]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Challenge::class)]
    #[Groups(self::ITEM_READ)]
    private Challenge $challenge;

    #[ORM\Column(type: 'datetime')]
    #[Groups(self::ITEM_READ)]
    private \DateTime $date;

    #[ORM\Column(type: 'string')]
    #[Groups(self::ITEM_READ)]
    private string $name;

    #[ORM\Column(type: 'text')]
    #[Groups(self::ITEM_READ)]
    private string $description;

    #[ORM\Column(type: 'integer')]
    #[Groups(self::ITEM_READ)]
    private int $points;

    #[ORM\Column(type: 'integer')]
    #[Groups(self::ITEM_READ)]
    private int $coins;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public function getCoins(): int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): void
    {
        $this->coins = $coins;
    }
}
