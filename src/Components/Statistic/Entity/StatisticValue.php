<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Player\Entity\PlayerStatistics;

class StatisticValue implements StatisticValueInterface
{
    private string $uuid;

    private Statistic $statistic;

    private PlayerStatistics $playerStatistics;

    private int $value;

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
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
