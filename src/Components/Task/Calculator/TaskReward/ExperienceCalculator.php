<?php

declare(strict_types=1);

namespace App\Components\Task\Calculator\TaskReward;

use App\Components\Task\Entity\TaskInterface;

final class ExperienceCalculator implements ExperienceCalculatorInterface
{
    private const DIFFICULTY_MULTIPLIER_MAP = [
        TaskInterface::EASY => 1,
        TaskInterface::MEDIUM => 2,
        TaskInterface::HARD => 3,
    ];

    public function calculate(TaskInterface $task): int
    {
        $player = $task->getPlayer();

        return 10 * self::DIFFICULTY_MULTIPLIER_MAP[$task->getDifficulty()] * $player->getPlayerLevel();
    }
}
