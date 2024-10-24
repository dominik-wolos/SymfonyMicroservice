<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Statistic\Entity\StatisticValue;
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

    #[ORM\OneToOne(targetEntity: Player::class)]
    #[Valid()]
    #[NotNull()]
    #[Groups([self::ITEM_READ])]
    private Player $player;

    #[ORM\OneToMany(mappedBy: 'playerStatistics', targetEntity: StatisticValue::class)]
    #[Valid()]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private Collection $statisticValues;

    public function __construct()
    {
        $this->statisticValues = new ArrayCollection();
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

    public function getStatisticValues(): Collection
    {
        return $this->statisticValues;
    }

    public function setStatisticValues(Collection $statisticValues): void
    {
        $this->statisticValues = $statisticValues;
    }

    public function addStatisticValue(StatisticValue $statisticValue): void
    {
        if ($this->hasStatisticValue($statisticValue)) {
            return;
        }

        $this->statisticValues->add($statisticValue);
    }

    public function removeStatisticValue(StatisticValue $statisticValue): void
    {
        if (!$this->hasStatisticValue($statisticValue)) {
            return;
        }

        $this->statisticValues->removeElement($statisticValue);
    }

    private function hasStatisticValue(StatisticValue $statisticValue): bool
    {
        return $this->statisticValues->contains($statisticValue);
    }
}
