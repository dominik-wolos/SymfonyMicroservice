<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Category\Entity\Category;

class CategoryStatistic implements CategoryStatisticInterface
{
    private string $uuid;

    private ?Category $category = null;

    private ?Statistic $statistic = null;

    private ?int $multiplier = null;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    public function getStatistic(): ?Statistic
    {
        return $this->statistic;
    }

    public function setStatistic(?Statistic $statistic): void
    {
        $this->statistic = $statistic;
    }

    public function getMultiplier(): ?int
    {
        return $this->multiplier;
    }

    public function setMultiplier(?int $multiplier): void
    {
        $this->multiplier = $multiplier;
    }
}
