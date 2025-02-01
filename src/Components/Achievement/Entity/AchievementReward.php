<?php

declare(strict_types=1);

namespace App\Components\Achievement\Entity;

use App\Api\DataProvider\DirectPlayerResourceInterface;
use App\Components\Player\Entity\Player;
use App\Components\Player\Entity\PlayerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AchievementReward implements AchievementRewardInterface, DirectPlayerResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    private PlayerInterface $player;

    #[ORM\ManyToOne(targetEntity: Achievement::class)]
    private AchievementInterface $achievement;

    #[ORM\Column(type: 'integer')]
    private int $coins;

    #[ORM\Column(type: 'integer')]
    private int $experience;

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

    public function getAchievement(): AchievementInterface
    {
        return $this->achievement;
    }

    public function setAchievement(AchievementInterface $achievement): void
    {
        $this->achievement = $achievement;
    }

    public function getCoins(): int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): void
    {
        $this->coins = $coins;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): void
    {
        $this->experience = $experience;
    }

    public function canBeCollected(): bool
    {
        return isset($this->id);
    }
}
