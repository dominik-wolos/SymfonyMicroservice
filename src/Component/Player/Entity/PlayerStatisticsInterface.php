<?php

declare(strict_types=1);

namespace App\Component\Player\Entity;

use App\Component\Statistic\Entity\StatisticValue;
use Doctrine\Common\Collections\Collection;

interface PlayerStatisticsInterface
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getPlayer(): Player;

    public function setPlayer(Player $player): void;

    public function getStatisticValues(): Collection;

    public function setStatisticValues(Collection $statisticValues): void;

    public function addStatisticValue(StatisticValue $statisticValue): void;

    public function removeStatisticValue(StatisticValue $statisticValue): void;
}
