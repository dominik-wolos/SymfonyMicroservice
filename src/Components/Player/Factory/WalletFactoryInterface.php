<?php

declare(strict_types=1);

namespace App\Components\Player\Factory;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Entity\WalletInterface;

interface WalletFactoryInterface
{
    public function create(): WalletInterface;

    public function createForPlayer(PlayerInterface $player): WalletInterface;
}
