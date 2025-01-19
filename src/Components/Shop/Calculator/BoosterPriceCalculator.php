<?php

declare(strict_types=1);

namespace App\Components\Shop\Calculator;

use App\Components\Shop\Entity\AugmentInterface;
use App\Components\Shop\Enum\AugmentTypes;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::TAG)]
final class BoosterPriceCalculator extends AugmentPriceCalculator
{
    public function calculate(AugmentInterface $augment): int
    {
        $augment->setPrice($augment->getValidForDays() * $augment->getMultiplier() * 2);
    }

    public function supports(AugmentInterface $augment): bool
    {
        return $augment->getType() === AugmentTypes::BOOSTER;
    }
}
