<?php

declare(strict_types=1);

namespace App\Components\Achievement\Entity;

use App\Components\Player\Entity\PlayerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AchievementReward implements AchievementRewardInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\OneToOne(targetEntity: Achievement::class, inversedBy: 'reward')]
    private AchievementInterface $achievement;

    #[ORM\Column(type: 'integer')]
    private int $coins;

    #[ORM\Column(type: 'integer')]
    private int $experience;

    public function getId(): int
    {
        return $this->id;
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

    public function getPlayer(): PlayerInterface
    {
        return $this->achievement->getPlayer();
    }
}
