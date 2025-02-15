<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\Controller\CompleteTaskController;
use App\Api\DataProvider\DirectPlayerResourceInterface;
use App\Components\Category\Entity\Category;
use App\Components\Player\Entity\Player;
use App\Components\Task\Processor\TaskCreationProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
            ],
            ],
            denormalizationContext: ['groups' => [
                self::WRITE,
            ]],
        ),
        new Patch(
            uriTemplate: 'task/{id}/complete',
            controller: CompleteTaskController::class,
            read: false,
            deserialize: false,
            normalizationContext: ['groups' => []],
            denormalizationContext: ['groups' => []],
        ),
        new Delete(),
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE]],
)]
#[ORM\Entity]
#[ORM\Table(name: 'task')]
class Task implements TaskInterface, DirectPlayerResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    private string $code;

    #[ORM\Column(type: 'string')]
    #[Groups([self::ITEM_READ, self::CREATE])]
    #[Assert\Choice(choices: self::TYPES)]
    private string $type;

    #[ORM\Column(type: 'string', unique: false)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Player $player;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\Column(type: 'string')]
    #[Groups([self::ITEM_READ, self::WRITE])]
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
    #[ApiFilter(DateFilter::class, strategy: DateFilter::EXCLUDE_NULL)]
    #[ApiFilter(OrderFilter::class, properties: ['startsAt' => 'DESC'], arguments: ['orderParameterName' => 'order'])]
    private \DateTimeInterface $startsAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private \DateTimeInterface $endsAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private \DateTimeInterface $recurringEndsAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups([self::ITEM_READ])]
    private ?\DateTimeImmutable $completedAt = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(nullable: true, unique: false)]
    private ?Task $mainTask = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $measureUnit;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private int $period;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastRecursionStartsAt = null;

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

    public function getCategory(): ?Category
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

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTimeImmutable $completedAt): void
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

    public function getMainTask(): ?self
    {
        return $this->mainTask;
    }

    public function setMainTask(?self $mainTask): void
    {
        $this->mainTask = $mainTask;
    }

    public function getMeasureUnit(): string
    {
        return $this->measureUnit;
    }

    public function setMeasureUnit(string $measureUnit): void
    {
        $this->measureUnit = $measureUnit;
    }

    #[Groups([self::ITEM_READ])]
    public function getInterval(): int
    {
        return $this->period;
    }

    public function getLastRecursionStartsAt(): ?\DateTimeInterface
    {
        return $this->lastRecursionStartsAt;
    }

    public function setLastRecursionStartsAt(\DateTimeInterface $lastRecursionStartsAt): void
    {
        $this->lastRecursionStartsAt = $lastRecursionStartsAt;
    }

    public function __clone(): void
    {
        $this->code = uniqid('task_', true);
        $this->completedAt = null;
    }

    public function getRecurringEndsAt(): \DateTimeInterface
    {
        return $this->recurringEndsAt;
    }

    public function setRecurringEndsAt(\DateTimeInterface $recurringEndsAt): void
    {
        $this->recurringEndsAt = $recurringEndsAt;
    }

    #[Groups([self::WRITE])]
    public function setInterval(int $period): void
    {
        $this->period = $period;
    }
}
