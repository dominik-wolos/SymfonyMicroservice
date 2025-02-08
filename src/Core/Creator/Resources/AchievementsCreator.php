<?php

declare(strict_types=1);

namespace App\Core\Creator\Resources;

use App\Components\Achievement\Factory\AchievementFactoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class AchievementsCreator implements AchievementsCreatorInterface
{
    public function __construct(
        #[Autowire('%app.fixtures.achievements%')]
        private readonly array $achievementsFixtures,
        private readonly AchievementFactoryInterface $achievementFactory,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create(PlayerInterface $player): void
    {
        $completedTasksAchievements = $this->achievementsFixtures['completed_tasks'];

        foreach ($completedTasksAchievements['levels'] as $level) {
            $achievement = $this->achievementFactory->createForPlayerAndTypeAndValue(
                $player,
                $level
            );
            $achievement->setCoins($level);
            $achievement->setExperience($level);

            $this->entityManager->persist($achievement);
        }
    }
}
