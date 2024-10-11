<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Player\Entity\PlayerStatistics;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => [
                self::ITEM_READ,
            ]]
        ),
        new Get(normalizationContext: ['groups' => [
            self::READ,
            self::ITEM_READ
        ]]),
        new Post(
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ
            ]
            ],
            denormalizationContext: ['groups' => [
                self::CREATE,
                self::WRITE
            ]]
        ),
        new Patch(
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ
            ]],
            denormalizationContext: ['groups' => [
                self::WRITE
            ]]
        ),
        new Delete()
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE]]
)]
#[ORM\Entity]
#[ORM\Table(name: 'statistic_value')]
class StatisticValue implements StatisticValueInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Statistic::class)]
    #[Groups([self::ITEM_READ, self::CREATE])]
    private Statistic $statistic;

    #[ORM\ManyToOne(targetEntity: PlayerStatistics::class, inversedBy: 'statisticValues', fetch: 'LAZY')]
    #[Groups([self::ITEM_READ, self::CREATE])]
    private PlayerStatistics $playerStatistics;

    #[ORM\Column(type: 'integer')]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private int $value;

    #[ORM\Column(type: 'integer')]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private int $level;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatistic(): Statistic
    {
        return $this->statistic;
    }

    public function setStatistic(Statistic $statistic): void
    {
        $this->statistic = $statistic;
    }

    public function getPlayerStatistics(): PlayerStatistics
    {
        return $this->playerStatistics;
    }

    public function setPlayerStatistics(PlayerStatistics $playerStatistics): void
    {
        $this->playerStatistics = $playerStatistics;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }
}
