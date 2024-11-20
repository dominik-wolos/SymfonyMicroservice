<?php

declare(strict_types=1);

namespace App\Components\Statistic\Factory;

use App\Components\Player\Entity\PlayerStatisticsInterface;
use App\Components\Statistic\Entity\StatisticInterface;
use App\Components\Statistic\Entity\StatisticValue;
use App\Components\Statistic\Entity\StatisticValueInterface;

final class StatisticValueFactory implements StatisticValueFactoryInterface
{
    public function createNew(): StatisticValueInterface
    {
        return new StatisticValue();
    }

    public function createForPlayerStatisticsAndStatistic(
        PlayerStatisticsInterface $playerStatistics,
        StatisticInterface $statistic
    ): StatisticValueInterface
    {
        $statisticValue = $this->createNew();
        $statisticValue->setPlayerStatistics($playerStatistics);
        $statisticValue->setStatistic($statistic);

        return $statisticValue;
    }
}
