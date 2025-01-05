<?php

declare(strict_types=1);

namespace App\Components\Player\Factory;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Entity\PlayerStatistics;
use App\Components\Player\Entity\PlayerStatisticsInterface;

final class PlayerStatisticsFactory implements PlayerStatisticsFactoryInterface
{
    public function createNew(): PlayerStatisticsInterface
    {
        return new PlayerStatistics();
    }

    public function createForPlayer(PlayerInterface $player): PlayerStatisticsInterface
    {
        $playerStatistics = $this->createNew();
        $playerStatistics->setPlayer($player);

        return $playerStatistics;
    }
}
