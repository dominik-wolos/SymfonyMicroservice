<?php

declare(strict_types=1);

namespace App\Components\Category\Entity;

use App\Components\Statistic\Entity\CategoryStatistic;
use Doctrine\Common\Collections\Collection;

class Category implements CategoryInterface
{
    private int $id;

    private string $name;

    /** @var Collection|CategoryStatistic[] */
    private Collection $categoryStatistics;

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

    public function getCategoryStatistics(): Collection
    {
        return $this->categoryStatistics;
    }

    public function setCategoryStatistics(Collection $categoryStatistics): void
    {
        $this->categoryStatistics = $categoryStatistics;
    }

    public function addCategoryStatistic(CategoryStatistic $categoryStatistic): void
    {
        if ($this->hasCategoryStatistic($categoryStatistic)) {
            return;
        }

        $this->categoryStatistics->add($categoryStatistic);
    }

    public function removeCategoryStatistic(CategoryStatistic $categoryStatistic): void
    {
        if (!$this->hasCategoryStatistic($categoryStatistic)) {
            return;
        }

        $this->categoryStatistics->removeElement($categoryStatistic);
    }

    public function hasCategoryStatistic(CategoryStatistic $categoryStatistic): bool
    {
        return $this->categoryStatistics->contains($categoryStatistic);
    }
}
