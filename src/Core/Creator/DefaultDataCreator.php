<?php

declare(strict_types=1);

namespace App\Core\Creator;

use App\Components\Category\Factory\CategoryFactoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Factory\PlayerStatisticsFactoryInterface;
use App\Components\Statistic\Factory\StatisticFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class DefaultDataCreator implements DefaultDataCreatorInterface
{
    public function __construct(
        private CategoryFactoryInterface $categoryFactory,
        private StatisticFactoryInterface $statisticFactory,
        private StatisticRelatedResourcesCreatorInterface $statisticRelatedResourcesCreator,
        private PlayerStatisticsFactoryInterface $playerStatisticsFactory,
        private EntityManagerInterface $entityManager,
        #[Autowire('%app.fixtures.default_categories%')]
        private array $defaultCategories,
        #[Autowire('%app.fixtures.default_statistics%')]
        private array $defaultStatistics
    ) {
    }

    public function create(PlayerInterface $player): void
    {
        $categories = [];
        $player->setPlayerLevel(1);
        $player->setPlayerExperience(0);
        $player->setPlayerStatistics($this->playerStatisticsFactory->createForPlayer($player));
        foreach ($this->defaultCategories as $category) {
            $categoryName = $category['name'];
            $categoryCode = $category['code'];

            $category = $this->categoryFactory->createForPlayerAndCodeAndName(
                $player,
                $categoryCode,
                $categoryName
            );

            $this->entityManager->persist($category);

            $categories[$categoryCode] = $category;
        }

        foreach ($this->defaultStatistics as $statistic) {
            $statisticName = $statistic['name'];
            $statisticCode = $statistic['code'];
            $categoryCode = $statistic['category'];
            $iconPath = $statistic['icon_path'];

            $statistic = $this->statisticFactory->createForPlayerAndCodeAndName(
                $player,
                $statisticName,
                $statisticCode,
            );
            $statistic->setIconPath($iconPath);

            $statistic->setIconPath($iconPath);
            $this->entityManager->persist($statistic);

            $category = $categories[$categoryCode] ?? null;

            $this->statisticRelatedResourcesCreator->create(
                $player,
                $statistic,
                $category,
                false
            );
        }

        $this->entityManager->flush();
    }
}
