<?php

declare(strict_types=1);

namespace App\Components\Task\Manager;

use App\Components\Shop\Entity\AugmentInterface;
use App\Components\Shop\Enum\AugmentTypes;
use App\Components\Shop\Repository\AugmentRepository;
use App\Components\Statistic\Entity\CategoryStatistic;
use App\Components\Task\Creator\TaskRewardCreatorInterface;
use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Entity\TaskRewardInterface;

final class TaskManager implements TaskManagerInterface
{
    public function __construct(
        private readonly TaskRewardCreatorInterface $taskRewardCreator,
        private readonly AugmentRepository $augmentRepository
    ) {
    }

    public function complete(TaskInterface $task): void
    {
        if (null !== $task->getCompletedAt() || TaskInterface::COMPLETED === $task->getStatus()) {
            throw new \Exception('Task already completed');
            return;
        }

        $task->setCompletedAt(new \DateTimeImmutable());
        $reward = $this->taskRewardCreator->create($task);

        $this->depositReward($task, $reward);
        $this->assignExperienceToStatistics($task, $reward);
        $this->assignExperienceToPlayer($task, $reward);

        $task->setStatus(TaskInterface::COMPLETED);
    }

    public function depositReward(TaskInterface $task, TaskRewardInterface $reward): void
    {
        $wallet = $task->getPlayer()->getWallet();
        $wallet->deposit($reward);
    }

    public function assignExperienceToStatistics(TaskInterface $task, TaskRewardInterface $reward): void
    {
        $category = $task->getCategory();
        if (null === $category) {
            if (TaskInterface::CHALLENGE === $task->getType()) {
                return;
            }
            throw new \Exception('Task without category must be a challenge');
        }
        $player = $task->getPlayer();

        $augment = $this->augmentRepository->findAllActiveAugmentsByPlayerAndTypeAndCategory(
            $player,
            AugmentTypes::BOOSTER,
            $category
        );

        $categoryStatistics = $category->getCategoryStatistics();
        $summedMultiplier = 0;
        $augmentMultiplier = $augment instanceof AugmentInterface ? $augment->getMultiplier() : 1;
        /**@var $categoryStatistic CategoryStatistic */
        foreach ($categoryStatistics as $categoryStatistic) {
            $summedMultiplier += $categoryStatistic->getMultiplier();
        }

        foreach ($categoryStatistics as $categoryStatistic) {
            $statistic = $categoryStatistic->getStatistic();
            $experience = $reward->getExperience() * ($categoryStatistic->getMultiplier() / $summedMultiplier);

            $statistic->addExperience($experience * $augmentMultiplier);
        }
    }

    private function assignExperienceToPlayer(TaskInterface $task, TaskRewardInterface $reward): void
    {
        $player = $task->getPlayer();
        $player->addExperience($reward->getExperience());
    }
}
