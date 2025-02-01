<?php

declare(strict_types=1);

namespace App\Core\Creator;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\StatisticInterface;

interface StatisticRelatedResourcesCreatorInterface
{
    public function create(
        PlayerInterface $player,
        StatisticInterface $statistic,
        CategoryInterface $category = null,
        bool $flush = true,
    ): void;
}
