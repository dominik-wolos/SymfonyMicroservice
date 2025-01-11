<?php

declare(strict_types=1);

namespace App\Components\Category\Entity;

use App\Components\Statistic\Entity\CategoryStatistic;
use App\Components\Statistic\Entity\CategoryStatisticInterface;
use Doctrine\Common\Collections\Collection;

interface CategoryInterface
{
    public const CREATE = 'category:create';

    public const WRITE = 'category:write';

    public const READ = 'category:read';

    public const ITEM_READ = 'category:item:read';

    public const UPDATE = 'category:update';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getCategoryStatistics(): Collection;

    public function setCategoryStatistics(Collection $categoryStatistics): void;

    public function addCategoryStatistic(CategoryStatistic $categoryStatistic): void;

    public function removeCategoryStatistic(CategoryStatistic $categoryStatistic): void;

    public function getStatisticsIds(): array;

    public function setStatisticsIds(array $statistics): void;

    public function getCategoryStatisticByStatisticId(int $removeId): ?CategoryStatisticInterface;
}
