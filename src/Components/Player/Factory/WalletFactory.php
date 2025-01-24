<?php

declare(strict_types=1);

namespace App\Components\Player\Factory;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Entity\Wallet;
use App\Components\Player\Entity\WalletInterface;

final class WalletFactory implements WalletFactoryInterface
{
    private const DEFAULT_BALANCE = 50;

    public function create(): WalletInterface
    {
        return new Wallet(self::DEFAULT_BALANCE);
    }

    public function createForPlayer(PlayerInterface $player): WalletInterface
    {
        $wallet = $this->create();
        $wallet->setPlayer($player);

        return $wallet;
    }
}
