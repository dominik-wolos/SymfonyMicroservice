<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Statistic\Entity\StatisticInterface;
use Doctrine\Common\Collections\Collection;

interface PlayerStatisticsInterface
{
    public const CREATE = 'player_statistics:create';

    public const WRITE = 'player_statistics:write';

    public const READ = 'player_statistics:read';

    public const ITEM_READ = 'player_statistics:item:read';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getPlayer(): Player;

    public function setPlayer(Player $player): void;

    public function getStatistics(): Collection;

    public function setStatistics(Collection $statistic): void;

    public function addStatistic(StatisticInterface $statistic): void;

    public function removeStatistic(StatisticInterface $statistic): void;

    public function hasStatistic(StatisticInterface $statistic): bool;
}
