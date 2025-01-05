<?php

declare(strict_types=1);

namespace App\Components\Task\Calculator\TaskReward;

use App\Components\Task\Entity\TaskInterface;

final class ExperienceCalculator implements ExperienceCalculatorInterface
{
    public function calculate(TaskInterface $task): int
    {
        $player = $task->getPlayer();

        if (5 > $player->getPlayerLevel()) {
            return 25;
        }

        return 15;
    }
}
