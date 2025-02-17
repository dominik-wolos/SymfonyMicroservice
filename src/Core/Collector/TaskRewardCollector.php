<?php

declare(strict_types=1);

namespace App\Core\Collector;

use App\Components\Shop\Entity\AugmentInterface;
use App\Components\Shop\Enum\AugmentTypes;
use App\Components\Shop\Repository\AugmentRepository;
use App\Components\Statistic\Entity\CategoryStatistic;
use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Entity\TaskRewardInterface;
use App\Core\Interface\RewardInterface;

final class TaskRewardCollector extends RewardCollector implements TaskRewardCollectorInterface
{
    public function __construct(
        private readonly AugmentRepository $augmentRepository,
    ) {
    }

    public function collect(RewardInterface $reward): void
    {
        $player = $reward->getPlayer();

        if (!$reward instanceof TaskRewardInterface) {
            throw new \Exception('Invalid reward type');
        }

        $task = $reward->getTask();
        $category = $task->getCategory();
        if (null !== $category) {
            $shield = $this->augmentRepository->findActiveAugmentByPlayerAndTypeAndCategory(
                $player,
                AugmentTypes::SHIELD,
                $category,
            );

            if (
                TaskInterface::EXPIRED === $task->getStatus()
                && null !== $shield
            ) {
                return;
            }
        }

        $this->collectCoins($reward);
        $this->assignExperienceToStatistics($reward);
        $this->assignExperienceToPlayer($reward);
    }

    public function assignExperienceToStatistics(TaskRewardInterface $reward): void
    {
        $task = $reward->getTask();
        $category = $task->getCategory();

        if (null === $category) {
            if (TaskInterface::CHALLENGE === $task->getType()) {
                return;
            }

            throw new \Exception('Task without category must be a challenge');
        }
        $player = $task->getPlayer();

        $augment = $this->augmentRepository->findActiveAugmentByPlayerAndTypeAndCategory(
            $player,
            AugmentTypes::BOOSTER,
            $category,
        );

        $categoryStatistics = $category->getCategoryStatistics();
        $summedMultiplier = 0;
        $augmentMultiplier = $augment instanceof AugmentInterface ? $augment->getMultiplier() : 1;

        /** @var CategoryStatistic $categoryStatistic */
        foreach ($categoryStatistics as $categoryStatistic) {
            $summedMultiplier += $categoryStatistic->getMultiplier();
        }

        foreach ($categoryStatistics as $categoryStatistic) {
            $statistic = $categoryStatistic->getStatistic();
            $experience = $reward->getExperience() * ($categoryStatistic->getMultiplier() / $summedMultiplier);

            $statistic->addExperience($experience * $augmentMultiplier);
        }
    }
}
