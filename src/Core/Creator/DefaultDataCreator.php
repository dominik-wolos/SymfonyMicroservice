<?php

declare(strict_types=1);

namespace App\Core\Creator;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Factory\PlayerStatisticsFactoryInterface;
use App\Components\Player\Factory\WalletFactoryInterface;
use App\Core\Creator\Resources\AchievementsCreatorInterface;
use App\Core\Creator\Resources\CategoryCreatorInterface;
use App\Core\Creator\Resources\StatisticCreatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class DefaultDataCreator implements DefaultDataCreatorInterface
{
    public function __construct(
        private CategoryCreatorInterface $categoryCreator,
        private StatisticCreatorInterface $statisticCreator,
        private AchievementsCreatorInterface $achievementsCreator,
        private PlayerStatisticsFactoryInterface $playerStatisticsFactory,
        private WalletFactoryInterface $walletFactory,
        private EntityManagerInterface $entityManager,
        #[Autowire('%app.fixtures.default_categories%')] private array $defaultCategories,
        #[Autowire('%app.fixtures.default_statistics%')] private array $defaultStatistics,
    ) {
    }

    public function create(PlayerInterface $player): void
    {
        $categories = [];
        $player->setPlayerLevel(1);
        $player->setPlayerExperience(0);
        $player->setPlayerStatistics($this->playerStatisticsFactory->createForPlayer($player));
        foreach ($this->defaultCategories as $category) {
            $categoryCode = $category['code'];
            $category = $this->categoryCreator->createFromArray($category, $player);

            $this->entityManager->persist($category);

            $categories[$categoryCode] = $category;
        }

        foreach ($this->defaultStatistics as $statistic) {
            $categoryCode = $statistic['category'];
            $category = $categories[$categoryCode] ?? null;

            $this->statisticCreator->createFromArray($statistic, $player, $category);
        }
        $this->walletFactory->createForPlayer($player);
        $this->achievementsCreator->create($player);

        $this->entityManager->flush();
    }
}
