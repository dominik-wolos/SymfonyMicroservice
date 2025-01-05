<?php

declare(strict_types=1);

namespace App\Components\Category\Factory;

use App\Components\Category\Entity\Category;
use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;

final class CategoryFactory implements CategoryFactoryInterface
{
    public function createNew(): CategoryInterface
    {
        return new Category();
    }

    public function createForPlayerAndCodeAndName(
        PlayerInterface $player,
        string $code,
        string $name
    ): CategoryInterface {
        $category = new Category();
        $category->setPlayer($player);
        $category->setCode(uniqid($code, true));
        $category->setName($name);

        return $category;
    }
}
