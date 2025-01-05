<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Category\Entity\Category;
use App\Components\Player\Entity\Player;
use App\Components\Task\Processor\TaskCreationProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => [
                self::ITEM_READ,
            ]],
        ),
        new Get(normalizationContext: ['groups' => [
            self::READ,
            self::ITEM_READ,
        ]]),
        new Post(
            processor: TaskCreationProcessor::class,
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ,
            ],
            ],
            denormalizationContext: ['groups' => [
                self::CREATE,
                self::WRITE,
            ]],
        ),
        new Patch(
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ,
            ]],
            denormalizationContext: ['groups' => [
                self::WRITE,
            ]],
        ),
        new Delete(),
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE]],
)]
#[ORM\Entity]
#[ORM\Table(name: 'task')]
class Task implements TaskInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::ITEM_READ])]
    private string $code;

    #[ORM\Column(type: 'string')]
    #[Groups([self::ITEM_READ, self::CREATE])]
    private string $type;

    #[ORM\Column(type: 'string', unique: false)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups([self::READ, self::WRITE])]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    #[Groups([self::ITEM_READ])]
    private Player $player;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private Category $category;

    #[ORM\Column(type: 'string')]
    #[Groups([self::READ, self::WRITE])]
    private string $difficulty;

    #[ORM\Column(type: 'string')]
    #[Groups([self::ITEM_READ])]
    private string $status = self::NEW;

    #[ORM\OneToOne(
        targetEntity: TaskReward::class,
        mappedBy: 'task',
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
    )]
    #[Groups([self::ITEM_READ])]
    private TaskRewardInterface $reward;

    #[ORM\Column(type: 'datetime')]
    #[Groups([self::ITEM_READ])]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private \DateTimeInterface $startsAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private \DateTimeInterface $endsAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups([self::ITEM_READ])]
    private \DateTime $completedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->code = uniqid('task_', true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getDifficulty(): string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCompletedAt(): \DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTime $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getReward(): TaskRewardInterface
    {
        return $this->reward;
    }

    public function setReward(TaskRewardInterface $reward): void
    {
        $this->reward = $reward;
    }

    public function getStartsAt(): \DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeInterface $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): \DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTimeInterface $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
