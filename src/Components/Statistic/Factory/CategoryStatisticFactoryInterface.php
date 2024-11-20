<?php

declare(strict_types=1);

namespace App\Components\Statistic\Factory;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Statistic\Entity\CategoryStatisticInterface;
use App\Components\Statistic\Entity\StatisticInterface;

interface CategoryStatisticFactoryInterface
{
    public function createNew(): CategoryStatisticInterface;

    public function createForCategoryAndStatistic(
        CategoryInterface $category,
        StatisticInterface $statistic
    ): CategoryStatisticInterface;
}
