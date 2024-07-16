<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Category\Entity\Category;

interface CategoryStatisticInterface
{
    public function getUuid(): string;

    public function setUuid(string $uuid): void;

    public function getCategory(): ?Category;

    public function setCategory(?Category $category): void;

    public function getStatistic(): ?Statistic;

    public function setStatistic(?Statistic $statistic): void;

    public function getMultiplier(): ?int;

    public function setMultiplier(?int $multiplier): void;
}
