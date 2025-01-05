<?php

declare(strict_types=1);

namespace App\Components\Category\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\StatisticInterface;
use App\Components\Statistic\Factory\CategoryStatisticFactoryInterface;
use App\Components\Statistic\Repository\StatisticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

final class CategoryCreationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
        private readonly CategoryStatisticFactoryInterface $categoryStatisticFactory,
        private readonly StatisticRepository $statisticRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
         Assert::isInstanceOf($data, CategoryInterface::class);

        $player = $this->currentPlayerProvider->provide($operation, $uriVariables, $context);
         Assert::isInstanceOf($player, PlayerInterface::class);

        $data->setPlayer($player);
        $data->setCode(uniqid(sprintf('%s-', $player->getId()), true));

        $statisticsIds = array_filter(
            $data->getStatisticsIds(),
            fn (int $statisticId) => $player->getPlayerStatistics()->getStatistics()->exists(
                fn (int $key, StatisticInterface $statistic) => $statistic->getId() === $statisticId
            )
        );

        $statistics = $this->statisticRepository->findStatisticsByIdsAndPlayer(
            $statisticsIds,
            $player
        );

        foreach ($statistics as $statistic) {
            $categoryStatistic = $this->categoryStatisticFactory->createForCategoryAndStatistic($data, $statistic);
            $this->entityManager->persist($categoryStatistic);
        }

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
