<?php

declare(strict_types=1);

namespace App\Component\Statistic\Entity;

use App\Component\Task\Entity\Category;

class CategoryStatistic implements CategoryStatisticInterface
{
    private ?int $id = null;

    private ?Category $category = null;

    private ?Statistic $statistic = null;

    private ?int $multiplier = null;

    public function getId(): ?int
    {
        return $this->id;
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
