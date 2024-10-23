<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

interface TaskRewardInterface
{
    public const CREATE = 'task_reward:create';

    public const WRITE = 'task_reward:write';

    public const READ = 'task_reward:read';

    public const ITEM_READ = 'task_reward:item:read';

    public function getId(): int;

    public function setId(int $id): void;

    public function getCode(): string;

    public function setCode(string $code): void;

    public function getType(): string;

    public function setType(string $type): void;

    public function getExperiencePoints(): int;

    public function setExperiencePoints(int $experiencePoints): void;

    public function getTask(): TaskInterface;

    public function setTask(TaskInterface $task): void;

    public function canBeCollected(): bool;

    public function getRewardItem(): ?RewardItemInterface;

    public function setRewardItem(?RewardItemInterface $rewardItem): void;

    public function getCoins(): int;

    public function setCoins(int $coins): void;
}
