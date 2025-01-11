<?php

declare(strict_types=1);

namespace App\Components\Category\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Category\Assigner\StatisticsAssignerInterface;
use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;
use Webmozart\Assert\Assert;

final class CategoryProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
        private readonly StatisticsAssignerInterface $statisticsAssigner
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
         Assert::isInstanceOf($data, CategoryInterface::class);

        $player = $this->currentPlayerProvider->provide($operation, $uriVariables, $context);
         Assert::isInstanceOf($player, PlayerInterface::class);

        $data->setPlayer($player);
        $data->setCode(uniqid(sprintf('%s-', $player->getId()), true));

        $this->statisticsAssigner->assign($data, $player);

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
