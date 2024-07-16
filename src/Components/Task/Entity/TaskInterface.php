<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

use App\Components\Category\Entity\Category;
use App\Components\Player\Entity\Player;
use App\Components\Task\Enum\TaskDifficultyEnum;
use App\Components\Task\Enum\TaskStatusEnum;

interface TaskInterface
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): string;

    public function setDescription(string $description): void;

    public function getCode(): string;

    public function setCode(string $code): void;

    public function getPlayer(): Player;

    public function setPlayer(Player $player): void;

    public function getCategory(): Category;

    public function setCategory(Category $category): void;

    public function getDifficulty(): TaskDifficultyEnum;

    public function setDifficulty(TaskDifficultyEnum $difficulty): void;

    public function getStatus(): TaskStatusEnum;

    public function setStatus(TaskStatusEnum $status): void;

    public function getCreatedAt(): \DateTime;

    public function setCreatedAt(\DateTime $createdAt): void;

    public function getCompletedAt(): \DateTime;

    public function setCompletedAt(\DateTime $completedAt): void;
}
