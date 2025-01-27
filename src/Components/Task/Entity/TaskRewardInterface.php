<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

use App\Core\Interface\RewardInterface;

interface TaskRewardInterface extends RewardInterface
{
    public const CREATE = 'task_reward:create';

    public const WRITE = 'task_reward:write';

    public const READ = 'task_reward:read';

    public const ITEM_READ = 'task_reward:item:read';

    public function getId(): int;

    public function setId(int $id): void;

    public function getTask(): TaskInterface;

    public function setTask(TaskInterface $task): void;
}
