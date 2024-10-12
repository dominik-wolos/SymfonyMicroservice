<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
                self::WRITE
            ]]
        ),
        new Delete()
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE]]
)]
#[ORM\Entity]
#[ORM\Table(name: 'task_reward')]
class TaskReward implements TaskRewardInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private int $id;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $type;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::ITEM_READ, self::CREATE])]
    #[Assert\NotBlank]
    private string $code;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ, self::WRITE])]
    #[Assert\Positive]
    private int $experiencePoints;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'rewards')]
    #[Groups([self::ITEM_READ, self::CREATE])]
    private TaskInterface $task;

    #[ORM\OneToOne(targetEntity: RewardItem::class, inversedBy: 'taskReward')]
    #[Groups([self::ITEM_READ, self::CREATE])]
    private ?RewardItemInterface $rewardItem;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getExperiencePoints(): int
    {
        return $this->experiencePoints;
    }

    public function setExperiencePoints(int $experiencePoints): void
    {
        $this->experiencePoints = $experiencePoints;
    }

    public function getTask(): TaskInterface
    {
        return $this->task;
    }

    public function setTask(TaskInterface $task): void
    {
        $this->task = $task;
    }

    public function getRewardItem(): ?RewardItemInterface
    {
        return $this->rewardItem;
    }

    public function setRewardItem(?RewardItemInterface $rewardItem): void
    {
        $this->rewardItem = $rewardItem;
    }
}
