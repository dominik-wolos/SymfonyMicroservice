<?php

declare(strict_types=1);

namespace App\Core\Creator\Resources;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\StatisticInterface;
use App\Components\Statistic\Factory\CategoryStatisticFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class StatisticRelatedResourcesCreator implements StatisticRelatedResourcesCreatorInterface
{
    public function __construct(
        private CategoryStatisticFactoryInterface $categoryStatisticFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(
        PlayerInterface $player,
        StatisticInterface $statistic,
        CategoryInterface $category = null,
        bool $flush = true,
    ): void {
        $playerStatistics = $player->getPlayerStatistics();

        if (null !== $category) {
            $categoryStatistic = $this->categoryStatisticFactory->createForCategoryAndStatistic(
                $category,
                $statistic,
            );

            $this->entityManager->persist($categoryStatistic);
        }

        $this->entityManager->persist($playerStatistics);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
