<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Statistic\Entity\StatisticValue;
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

    public function getStatisticValues(): Collection;

    public function setStatisticValues(Collection $statisticValues): void;

    public function addStatisticValue(StatisticValue $statisticValue): void;

    public function removeStatisticValue(StatisticValue $statisticValue): void;
}
