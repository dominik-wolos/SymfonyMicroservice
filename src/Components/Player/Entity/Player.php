<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Task\Entity\RewardItem;
use App\Components\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Valid;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => [
                self::ITEM_READ,
            ]]
        ),
        new Get(normalizationContext: ['groups' => [
            self::READ,
            self::ITEM_READ
        ]]),
        new Post(
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ
            ]
            ],
            denormalizationContext: ['groups' => [
                self::CREATE,
                self::WRITE
            ]]
        ),
        new Patch(
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ
            ]],
            denormalizationContext: ['groups' => [
                self::WRITE,
            ]]
        ),
        new Delete()
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE,]]
)]
#[ORM\Entity]
#[ORM\Table(name: 'player')]
class Player implements PlayerInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[Groups([self::ITEM_READ, self::CREATE])]
    #[NotNull()]
    #[Valid()]
    private User $user;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    #[NotNull()]
    private string $name;

    #[ORM\ManyToMany(targetEntity: RewardItem::class, inversedBy: 'players')]
    #[ORM\JoinTable(name: 'players_rewards')]
    #[Valid]
    #[Groups([self::ITEM_READ, self::UPDATE])]
    private Collection $obtainedRewards;

    public function __construct()
    {
        $this->friends = new ArrayCollection();
        $this->obtainedRewards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getObtainedRewards(): Collection
    {
        return $this->obtainedRewards;
    }

    public function addObtainedReward(RewardItem $rewardItem): void
    {
        if (!$this->obtainedRewards->contains($rewardItem)) {
            $this->obtainedRewards->add($rewardItem);
        }
    }

    public function removeObtainedReward(RewardItem $rewardItem): void
    {
        if ($this->obtainedRewards->contains($rewardItem)) {
            $this->obtainedRewards->removeElement($rewardItem);
        }
    }
}
