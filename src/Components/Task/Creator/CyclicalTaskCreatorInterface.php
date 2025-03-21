<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Task\Entity\TaskInterface;

interface CyclicalTaskCreatorInterface
{
    public function createTasks(TaskInterface $task, bool $flush = true): void;
}
