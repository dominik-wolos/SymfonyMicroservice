<?php

declare(strict_types=1);

namespace App\Components\Shop\Calculator;

use App\Components\Shop\Entity\AugmentInterface;

abstract class AugmentPriceCalculator
{
    public const TAG = 'augment_price_calculator';

    abstract public function calculate(AugmentInterface $augment): int;

    abstract public function supports(AugmentInterface $augment): bool;
}
