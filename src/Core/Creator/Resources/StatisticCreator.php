<?php

declare(strict_types=1);

namespace App\Core\Creator\Resources;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\StatisticInterface;
use App\Components\Statistic\Factory\StatisticFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class StatisticCreator implements StatisticCreatorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private StatisticFactoryInterface $statisticFactory,
        private StatisticRelatedResourcesCreatorInterface $statisticRelatedResourcesCreator,
    ) {
    }

    public function createFromArray(
        array $row,
        PlayerInterface $player,
        ?CategoryInterface $category,
    ): StatisticInterface {
        $statisticName = $row['name'];
        $statisticCode = $row['code'];
        $iconPath = $row['icon_path'];

        $statistic = $this->statisticFactory->createForPlayerAndCodeAndName(
            $player,
            $statisticName,
            $statisticCode,
        );

        $statistic->setIconPath($iconPath);
        $this->entityManager->persist($statistic);

        $this->statisticRelatedResourcesCreator->create(
            $player,
            $statistic,
            $category,
            false,
        );

        return $statistic;
    }
}
