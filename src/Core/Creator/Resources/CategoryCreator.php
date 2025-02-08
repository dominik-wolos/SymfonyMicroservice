<?php

declare(strict_types=1);

namespace App\Core\Creator\Resources;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Category\Factory\CategoryFactoryInterface;
use App\Components\Player\Entity\PlayerInterface;

final readonly class CategoryCreator implements CategoryCreatorInterface
{
    public function __construct(
        private CategoryFactoryInterface $categoryFactory,
    ) {
    }

    public function createFromArray(array $category, PlayerInterface $player): CategoryInterface
    {
        $categoryName = $category['name'];
        $categoryCode = $category['code'];

        return $this->categoryFactory->createForPlayerAndCodeAndName(
            $player,
            $categoryCode,
            $categoryName,
        );
    }
}
