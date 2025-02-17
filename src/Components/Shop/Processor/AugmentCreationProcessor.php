<?php

declare(strict_types=1);

namespace App\Components\Shop\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Shop\Calculator\AugmentPriceCalculator;
use App\Components\Shop\Entity\AugmentInterface;
use App\Components\Shop\Repository\AugmentRepository;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Webmozart\Assert\Assert;

final class AugmentCreationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
        #[AutowireIterator(AugmentPriceCalculator::TAG)]
        private readonly iterable $augmentPriceCalculators,
        private readonly AugmentRepository $augmentRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, AugmentInterface::class);
        $player = $this->currentPlayerProvider->provide($operation, $uriVariables, $context);
        Assert::isInstanceOf($player, PlayerInterface::class);

        $augment = $this->augmentRepository->findActiveAugmentByPlayerAndTypeAndCategory(
            $player,
            $data->getType(),
            $data->getCategory(),
        );

        if (null !== $augment) {
            throw new \Exception('Player already has active augment of this type and category');
        }

        foreach ($this->augmentPriceCalculators as $augmentPriceCalculator) {
            if ($augmentPriceCalculator->supports($data)) {
                $augmentPriceCalculator->calculate($data);

                break;
            }
        }
        $data->setPlayer($player);
        $data->setEndsAt($data->getCreatedAt()->modify(sprintf('+%s day', $data->getValidForDays())));
        $wallet = $data->getPlayer()->getWallet();

        $wallet->purchase($data);

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
