<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Category\Entity\Category;

interface CategoryStatisticInterface
{
    public const CREATE = 'category_statistic:create';

    public const WRITE = 'category_statistic:write';

    public const READ = 'category_statistic:read';

    public const ITEM_READ = 'category_statistic:item:read';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getStatistic(): Statistic;

    public function getCategory(): Category;

    public function setCategory(Category $category): void;

    public function setStatistic(Statistic $statistic): void;

    public function getMultiplier(): int;

    public function setMultiplier(int $multiplier): void;

    public function getStatisticId(): ?int;
    }
