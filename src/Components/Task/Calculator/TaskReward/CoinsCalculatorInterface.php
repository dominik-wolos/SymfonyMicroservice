<?php

declare(strict_types=1);

namespace App\Components\Task\Calculator\TaskReward;

use App\Components\Task\Entity\TaskInterface;

interface CoinsCalculatorInterface
{
    public function calculate(TaskInterface $task): int;
}
