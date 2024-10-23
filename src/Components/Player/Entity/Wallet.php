<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Shop\Entity\OrderInterface;
use App\Components\Task\Entity\TaskRewardInterface;

class Wallet implements WalletInterface
{
    private int $id;

    private PlayerInterface $player;

    private int $balance;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    public function setPlayer(PlayerInterface $player): void
    {
        $this->player = $player;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function deposit(TaskRewardInterface $taskReward): void
    {
        if (!$taskReward->canBeCollected()) {
            throw new \Exception('Task is not completed');
        }
        $this->balance += $taskReward->getCoins();
    }

    public function purchase(OrderInterface $order): void
    {
        if ($order->isPaid()) {
            throw new \Exception('Order is already paid');
        }

        if ($this->balance < $order->getTotal()) {
            throw new \Exception('Not enough money');
        }

        $this->balance -= $order->getTotal();
    }
}
