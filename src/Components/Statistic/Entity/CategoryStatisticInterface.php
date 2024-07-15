<?php

declare(strict_types=1);

namespace App\Component\Statistic\Entity;

use App\Component\Category\Entity\Category;

interface CategoryStatisticInterface
{
    public function getId(): ?int;

    public function getCategory(): ?Category;

    public function setCategory(?Category $category): void;

    public function getStatistic(): ?Statistic;

    public function setStatistic(?Statistic $statistic): void;

    public function getMultiplier(): ?int;

    public function setMultiplier(?int $multiplier): void;
}
