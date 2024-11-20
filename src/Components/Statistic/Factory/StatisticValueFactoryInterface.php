<?php

declare(strict_types=1);

namespace App\Components\Statistic\Factory;

use App\Components\Player\Entity\PlayerStatisticsInterface;
use App\Components\Statistic\Entity\StatisticInterface;
use App\Components\Statistic\Entity\StatisticValueInterface;

interface StatisticValueFactoryInterface
{
    public function createNew(): StatisticValueInterface;

    public function createForPlayerStatisticsAndStatistic(
        PlayerStatisticsInterface $playerStatistics,
        StatisticInterface $statistic
    ): StatisticValueInterface;
}
