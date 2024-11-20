<?php

declare(strict_types=1);

namespace App\Components\Statistic\Factory;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\Statistic;
use App\Components\Statistic\Entity\StatisticInterface;

final class StatisticFactory implements StatisticFactoryInterface
{
    public function createNew(): StatisticInterface
    {
        return new Statistic();
    }

    public function createForPlayerAndCodeAndName(
        PlayerInterface $player,
        string $name,
        string $code
    ): StatisticInterface {
        $statistic = $this->createNew();
        $statistic->setName($name);
        $statistic->setCode(uniqid($code, true));
        $statistic->setPlayer($player);

        return $statistic;
    }
}
