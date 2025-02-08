<?php

declare(strict_types=1);

namespace App\Components\Achievement\Creator;

use App\Components\Achievement\Calculator\CoinsCalculatorInterface;
use App\Components\Achievement\Calculator\ExperienceCalculatorInterface;
use App\Components\Achievement\Entity\AchievementInterface;
use App\Components\Achievement\Entity\AchievementRewardInterface;
use App\Components\Achievement\Factory\AchievementRewardFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class AchievementRewardCreator implements AchievementRewardCreatorInterface
{
    public function __construct(
        private readonly AchievementRewardFactoryInterface $achievementRewardFactory,
        private readonly EntityManagerInterface $entityManager,
        private readonly CoinsCalculatorInterface $coinsCalculator,
        private readonly ExperienceCalculatorInterface $experienceCalculator,
    ) {
    }

    public function createForAchievement(
        AchievementInterface $achievement,
        bool $flush = true,
    ): AchievementRewardInterface {
        $reward = $this->achievementRewardFactory->createForAchievement($achievement);
        $reward->setCoins($this->coinsCalculator->calculate($achievement));
        $reward->setExperience($this->experienceCalculator->calculate($achievement));

        $this->entityManager->persist($reward);

        if ($flush) {
            $this->entityManager->flush();
        }

        return $reward;
    }
}
