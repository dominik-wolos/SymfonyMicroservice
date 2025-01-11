<?php

declare(strict_types=1);

namespace App\Components\Category\Assigner;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Category\Selector\StatisticsSelectorInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\CategoryStatisticInterface;
use App\Components\Statistic\Factory\CategoryStatisticFactoryInterface;
use App\Components\Statistic\Repository\CategoryStatisticRepository;
use App\Components\Statistic\Repository\StatisticRepository;
use Doctrine\ORM\EntityManagerInterface;

final class StatisticsAssigner implements StatisticsAssignerInterface
{
    public function __construct(
        private readonly CategoryStatisticFactoryInterface $categoryStatisticFactory,
        private readonly StatisticRepository $statisticRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function assign(CategoryInterface $category, PlayerInterface $player): void
    {
        $existingStatisticsIds = $category->getCategoryStatistics()->map(
            fn (CategoryStatisticInterface $categoryStatistic) => (string) $categoryStatistic->getStatisticId()
        )->toArray();

        $statisticIds = $category->getStatisticsIds();

        $createIds = array_diff($statisticIds, $existingStatisticsIds);
        $statisticsToAdd = $this->statisticRepository->findStatisticsByIdsAndPlayer($createIds, $player);

        foreach ($statisticsToAdd as $statistic) {
            $categoryStatistic = $this->categoryStatisticFactory->createForCategoryAndStatistic(
                $category,
                $statistic
            );

            $this->entityManager->persist($categoryStatistic);
        }

        $removeIds = array_diff($existingStatisticsIds, $statisticIds);
        foreach ($removeIds as $removeId) {
            $categoryStatistic = $category->getCategoryStatisticByStatisticId((int) $removeId);

            $this->entityManager->remove($categoryStatistic);
        }

        $this->entityManager->persist($category);
    }
}
