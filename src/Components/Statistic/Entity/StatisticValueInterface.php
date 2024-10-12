<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Player\Entity\PlayerStatistics;

interface StatisticValueInterface
{
    public const CREATE = 'statistic_value:create';

    public const WRITE = 'statistic_value:write';

    public const READ = 'statistic_value:read';

    public const ITEM_READ = 'statistic_value:item:read';

    public function setId(int $id): void;

    public function getId(): ?int;

    public function getStatistic(): Statistic;

    public function setStatistic(Statistic $statistic): void;

    public function getPlayerStatistics(): PlayerStatistics;

    public function setPlayerStatistics(PlayerStatistics $playerStatistics): void;

    public function getValue(): int;

    public function setValue(int $value): void;

    public function getLevel(): int;

    public function setLevel(int $level): void;
}
