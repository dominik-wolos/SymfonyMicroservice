<?php

declare(strict_types=1);

namespace App\Components\Statistic\Factory;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Statistic\Entity\CategoryStatistic;
use App\Components\Statistic\Entity\CategoryStatisticInterface;
use App\Components\Statistic\Entity\StatisticInterface;

final class CategoryStatisticFactory implements CategoryStatisticFactoryInterface
{
    public function createNew(): CategoryStatisticInterface
    {
        return new CategoryStatistic();
    }

    public function createForCategoryAndStatistic(
        CategoryInterface $category,
        StatisticInterface $statistic
    ): CategoryStatisticInterface {
        $categoryStatistic = $this->createNew();
        $categoryStatistic->setMultiplier(4 - $category->getCategoryStatistics()->count());

        $categoryStatistic->setCategory($category);
        $categoryStatistic->setStatistic($statistic);

        return $categoryStatistic;
    }
}
