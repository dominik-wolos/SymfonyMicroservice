<?php

declare(strict_types=1);

namespace App\Components\Statistic\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Statistic\Entity\StatisticInterface;
use Webmozart\Assert\Assert;

final class StatisticCreationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider
    ){
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($data, StatisticInterface::class);

        $player = $this->currentPlayerProvider->provide($operation, $uriVariables, $context);
        Assert::isInstanceOf($player, PlayerInterface::class);

        $playerStatistics = $player->getPlayerStatistics();
        $data->setPlayerStatistics($playerStatistics);
        $data->setLevel(1);
        $data->setExperience(0);
        $data->setCode(uniqid(sprintf('%s-', $player->getId()), true));

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
