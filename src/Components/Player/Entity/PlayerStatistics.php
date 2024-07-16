<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Statistic\Entity\StatisticValue;
use Doctrine\Common\Collections\Collection;

class PlayerStatistics implements PlayerStatisticsInterface
{
    private int $id;

    private Player $player;

    /** @var Collection|StatisticValue[] */
    private Collection $statisticValues;

    public function getId(): int
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
