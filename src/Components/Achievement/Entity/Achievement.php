<?php

declare(strict_types=1);

namespace App\Components\Achievements\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Achievement implements AchievementInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Column(type: 'string')]
    private string $state;

    #[ORM\Column(type: 'float')]
    private float $requiredValue;

    #[ORM\Column(type: 'integer')]
    private int $coins;

    #[ORM\Column(type: 'integer')]
    private int $experience;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getRequiredValue(): float
    {
        return $this->requiredValue;
    }

    public function setRequiredValue(float $requiredValue): void
    {
        $this->requiredValue = $requiredValue;
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

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }
}
