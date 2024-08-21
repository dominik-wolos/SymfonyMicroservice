<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Player\Entity\PlayerStatistics;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'statistic_value')]
class StatisticValue implements StatisticValueInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Statistic::class)]
    private Statistic $statistic;

    #[ORM\ManyToOne(targetEntity: PlayerStatistics::class)]
    private PlayerStatistics $playerStatistics;

    #[ORM\Column(type: 'integer')]
    private int $value;

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
}
