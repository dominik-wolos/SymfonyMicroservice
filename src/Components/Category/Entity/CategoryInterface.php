<?php

declare(strict_types=1);

namespace App\Components\Category\Entity;

use App\Components\Statistic\Entity\CategoryStatistic;
use Doctrine\Common\Collections\Collection;

interface CategoryInterface
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getCategoryStatistics(): Collection;

    public function setCategoryStatistics(Collection $categoryStatistics): void;

    public function addCategoryStatistic(CategoryStatistic $categoryStatistic): void;

    public function removeCategoryStatistic(CategoryStatistic $categoryStatistic): void;

    public function hasCategoryStatistic(CategoryStatistic $categoryStatistic): bool;
}
