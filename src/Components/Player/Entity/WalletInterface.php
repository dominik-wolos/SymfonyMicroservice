<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Shop\Entity\AugmentInterface;
use App\Core\Interface\RewardInterface;

interface WalletInterface
{
    public function getId(): int;

    public function getPlayer(): PlayerInterface;

    public function setPlayer(PlayerInterface $player): void;

    public function getBalance(): int;

    public function deposit(RewardInterface $taskReward): void;

    public function purchase(AugmentInterface $augment): void;
}
