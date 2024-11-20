<?php

declare(strict_types=1);

namespace App\Components\Player\Factory;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Entity\PlayerStatisticsInterface;

interface PlayerStatisticsFactoryInterface
{
    public function createNew(): PlayerStatisticsInterface;

    public function createForPlayer(PlayerInterface $player): PlayerStatisticsInterface;
}
