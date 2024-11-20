<?php

declare(strict_types=1);

namespace App\Core\Creator;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Factory\PlayerStatisticsFactoryInterface;
use App\Components\Statistic\Entity\StatisticInterface;
use App\Components\Statistic\Factory\CategoryStatisticFactoryInterface;
use App\Components\Statistic\Factory\StatisticValueFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class StatisticRelatedResourcesCreator implements StatisticRelatedResourcesCreatorInterface
{
    public function __construct(
        private CategoryStatisticFactoryInterface $categoryStatisticFactory,
        private StatisticValueFactoryInterface $statisticValueFactory,
        private PlayerStatisticsFactoryInterface $playerStatisticsFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(
        PlayerInterface $player,
        StatisticInterface $statistic,
        CategoryInterface $category = null,
        bool $flush = true
    ): void {
        $playerStatistics = $player->getPlayerStatistics();

        if (null !== $category) {
            $categoryStatistic = $this->categoryStatisticFactory->createForCategoryAndStatistic(
                $category,
                $statistic
            );

            $this->entityManager->persist($categoryStatistic);
        }

        $statisticValue = $this->statisticValueFactory->createForPlayerStatisticsAndStatistic(
            $playerStatistics,
            $statistic
        );

        $this->entityManager->persist($statisticValue);
        $this->entityManager->persist($playerStatistics);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
