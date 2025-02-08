<?php

declare(strict_types=1);

namespace App\Core\Collector;

use App\Core\Interface\RewardInterface;

abstract class RewardCollector
{
    abstract public function collect(RewardInterface $reward): void;

    protected function collectCoins(RewardInterface $reward): void
    {
        $player = $reward->getPlayer();
        $wallet = $player->getWallet();

        $wallet->deposit($reward);
    }

    protected function assignExperienceToPlayer(RewardInterface $reward): void
    {
        $player = $reward->getPlayer();
        $player->addExperience($reward->getExperience());
    }
}
