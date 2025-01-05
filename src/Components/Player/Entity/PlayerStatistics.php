<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Statistic\Entity\Statistic;
use App\Components\Statistic\Entity\StatisticInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Valid;

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
#[ORM\Table(name: 'player_statistics')]
class PlayerStatistics implements PlayerStatisticsInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Player::class, cascade: ['persist', 'remove'])]
    #[Valid()]
    #[NotNull()]
    #[Groups([self::ITEM_READ])]
    private Player $player;

    #[ORM\OneToMany(mappedBy: 'playerStatistics', targetEntity: Statistic::class)]
    #[Valid()]
    #[Groups([self::ITEM_READ, self::WRITE, PlayerInterface::ITEM_READ])]
    private Collection $statistics;

    public function __construct()
    {
        $this->statistics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function setStatistics(Collection $statistic): void
    {
        $this->statistics = $statistic;
    }

    public function addStatistic(StatisticInterface $statistic): void
    {
        if ($this->hasStatistic($statistic)) {
            return;
        }

        $this->statistics->add($statistic);
    }

    public function removeStatistic(StatisticInterface $statistic): void
    {
        if (!$this->hasStatistic($statistic)) {
            return;
        }

        $this->statistics->removeElement($statistic);
    }

    public function hasStatistic(StatisticInterface $statistic): bool
    {
        return $this->statistics->contains($statistic);
    }
}
