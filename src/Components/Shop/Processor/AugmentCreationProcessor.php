<?php

declare(strict_types=1);

namespace App\Components\Shop\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Shop\Calculator\AugmentPriceCalculator;
use App\Components\Shop\Entity\AugmentInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Webmozart\Assert\Assert;

final class AugmentCreationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
        #[AutowireIterator(AugmentPriceCalculator::TAG)]
        private readonly iterable $augmentPriceCalculators
    ){
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, AugmentInterface::class);

        foreach ($this->augmentPriceCalculators as $augmentPriceCalculator) {
            if ($augmentPriceCalculator->supports($data)) {
                $augmentPriceCalculator->calculate($data);

                break;
            }
        }
        $data->setPlayer($this->currentPlayerProvider->provide($operation, $uriVariables, $context));
        $wallet = $data->getPlayer()->getWallet();

        $wallet->purchase($data);

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
