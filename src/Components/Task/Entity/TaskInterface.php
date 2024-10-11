<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

use App\Components\Category\Entity\Category;
use App\Components\Player\Entity\Player;
use App\Components\Task\Enum\TaskDifficultyEnum;
use App\Components\Task\Enum\TaskStatusEnum;

interface TaskInterface
{
    public const CREATE = 'task:create';

    public const WRITE = 'task:write';

    public const READ = 'task:read';

    public const ITEM_READ = 'task:item:read';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): string;

    public function setDescription(string $description): void;

    public function getPlayer(): Player;

    public function setPlayer(Player $player): void;

    public function getCategory(): Category;

    public function setCategory(Category $category): void;

    public function getDifficulty(): string;

    public function setDifficulty(string $difficulty): void;

    public function getStatus(): string;

    public function setStatus(string $status): void;

    public function getCreatedAt(): \DateTime;

    public function setCreatedAt(\DateTime $createdAt): void;

    public function getCompletedAt(): \DateTime;

    public function setCompletedAt(\DateTime $completedAt): void;
}
