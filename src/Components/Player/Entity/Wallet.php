<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Api\DataProvider\DirectPlayerResourceInterface;
use App\Components\Shop\Entity\AugmentInterface;
use App\Core\Interface\RewardInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'wallet')]
class Wallet implements WalletInterface, DirectPlayerResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToOne(targetEntity: Player::class, inversedBy: 'wallet')]
    private PlayerInterface $player;

    #[ORM\Column(type: 'integer')]
    private int $balance;

    public function __construct(int $balance)
    {
        $this->balance = $balance;
    }

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
        $player->setWallet($this);
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function deposit(RewardInterface $taskReward): void
    {
        if (!$taskReward->canBeCollected()) {
            throw new \Exception('Reward cannot be collected');
        }
        $this->balance += $taskReward->getCoins();
    }

    public function purchase(AugmentInterface $augment): void
    {
        if (true === $augment->hasId()) {
            throw new \Exception('Augment is already purchased');
        }

        if ($this->balance < $augment->getPrice()) {
            throw new \Exception('Not enough coins');
        }

        $this->balance -= $augment->getPrice();
    }
}
