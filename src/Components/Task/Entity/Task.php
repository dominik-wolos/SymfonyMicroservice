<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

use App\Components\Category\Entity\Category;
use App\Components\Player\Entity\Player;
use App\Components\Task\Enum\TaskDifficultyEnum;
use App\Components\Task\Enum\TaskStatusEnum;

class Task implements TaskInterface
{
    private int $id;

    private string $code;

    private string $name;

    private string $description;

    private Player $player;

    private Category $category;

    private TaskDifficultyEnum $difficulty;

    private TaskStatusEnum $status;

    private \DateTime $createdAt;

    private \DateTime $completedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getDifficulty(): TaskDifficultyEnum
    {
        return $this->difficulty;
    }

    public function setDifficulty(TaskDifficultyEnum $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getStatus(): TaskStatusEnum
    {
        return $this->status;
    }

    public function setStatus(TaskStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCompletedAt(): \DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTime $completedAt): void
    {
        $this->completedAt = $completedAt;
    }
}
