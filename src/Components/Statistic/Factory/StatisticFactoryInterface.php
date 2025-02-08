<?php

declare(strict_types=1);

namespace App\Components\Statistic\Factory;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\StatisticInterface;

interface StatisticFactoryInterface
{
    public function createNew(): StatisticInterface;

    /**
     * @param PlayerInterface $player
     * @param string $name
     * @param string $code
     * @return StatisticInterface
     */
    public function createForPlayerAndCodeAndName(
        PlayerInterface $player,
        string $name,
        string $code,
    ): StatisticInterface;
}
