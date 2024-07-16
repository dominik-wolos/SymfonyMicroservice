<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Player\Entity\PlayerStatistics;

interface StatisticValueInterface
{
    public function setUuid(string $uuid): void;

    public function getUuid(): string;

    public function getStatistic(): Statistic;

    public function setStatistic(Statistic $statistic): void;

    public function getPlayerStatistics(): PlayerStatistics;

    public function setPlayerStatistics(PlayerStatistics $playerStatistics): void;

    public function getValue(): int;

    public function setValue(int $value): void;
}
