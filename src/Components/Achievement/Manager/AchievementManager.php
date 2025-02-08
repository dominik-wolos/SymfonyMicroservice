<?php

declare(strict_types=1);

namespace App\Components\Achievement\Manager;

use App\Components\Achievement\Checker\AchievementCheckerInterface;
use App\Components\Achievement\Creator\AchievementRewardCreatorInterface;
use App\Components\Achievement\Entity\AchievementInterface;
use App\Core\Collector\AchievementRewardCollectorInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AchievementManager implements AchievementManagerInterface
{
    public function __construct(
        private AchievementCheckerInterface $achievementChecker,
        private AchievementRewardCreatorInterface $achievementRewardCreator,
        private AchievementRewardCollectorInterface $achievementRewardCollector,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function complete(AchievementInterface $achievement): void
    {
        if (false === $this->achievementChecker->check($achievement)) {
            throw new \RuntimeException('Achievement can not be completed yet.');
        }
        $reward = $this->achievementRewardCreator->createForAchievement($achievement, false);

        $this->achievementRewardCollector->collect($reward);
        $achievement->setCompletedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
    }
}
