<?php

declare(strict_types=1);

namespace App\Components\Achievement\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Patch;
use App\Api\Controller\CompleteAchievementController;
use App\Components\Player\Entity\Player;
use App\Components\Player\Entity\PlayerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ApiResource(
    operations: [
    new Patch(
        uriTemplate: 'achievements/{id}/complete',
        controller: CompleteAchievementController::class,
        read: false,
        deserialize: false,
        normalizationContext: ['groups' => []],
        denormalizationContext: ['groups' => []],
    ),
],
)]
class Achievement implements AchievementInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([PlayerInterface::ITEM_READ])]
    private int $id;

    #[Groups([PlayerInterface::ITEM_READ])]
    #[ORM\Column(type: 'string')]
    private string $type;

    #[Groups([PlayerInterface::ITEM_READ])]
    #[ORM\Column(type: 'float')]
    private float $requiredValue;

    #[Groups([PlayerInterface::ITEM_READ])]
    #[ORM\Column(type: 'integer')]
    private int $coins;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Player $player;

    #[Groups([PlayerInterface::ITEM_READ])]
    #[ORM\Column(type: 'integer')]
    private int $experience;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeInterface $completedAt = null;

    #[ORM\OneToOne(targetEntity: AchievementReward::class, mappedBy: 'achievement')]
    private ?AchievementReward $achievementReward = null;

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

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTimeInterface $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    public function getAchievementReward(): ?AchievementReward
    {
        return $this->achievementReward;
    }

    public function setAchievementReward(?AchievementReward $achievementReward): void
    {
        $this->achievementReward = $achievementReward;
    }

    #[Groups([PlayerInterface::ITEM_READ])]
    public function isCompleted(): bool
    {
        return isset($this->completedAt);
    }
}
