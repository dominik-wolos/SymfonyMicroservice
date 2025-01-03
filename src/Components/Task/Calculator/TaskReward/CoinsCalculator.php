<?php

declare(strict_types=1);

namespace App\Components\Task\Calculator\TaskReward;

use App\Components\Task\Entity\TaskInterface;

final class CoinsCalculator implements CoinsCalculatorInterface
{
    public function calculate(TaskInterface $task): int
    {
        $player = $task->getPlayer();

        if ($player->getPlayerLevel() < 5) {
            return 1;
        }

        return 10;
    }
}
