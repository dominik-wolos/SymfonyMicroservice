<?php

declare(strict_types=1);

namespace App\Core\Creator\Resources;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\StatisticInterface;

interface StatisticCreatorInterface
{
    public function createFromArray(
        array $row,
        PlayerInterface $player,
        ?CategoryInterface $category
    ): StatisticInterface;
}
