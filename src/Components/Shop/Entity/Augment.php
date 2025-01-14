<?php

declare(strict_types=1);

namespace App\Components\Shop\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Category\Entity\Category;
use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\Player;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Shop\Enum\AugmentTypes;
use App\Components\Shop\Processor\AugmentCreationProcessor;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'augment')]
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
            processor: AugmentCreationProcessor::class,
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
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::CREATE]]
)]
class Augment implements AugmentInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Groups([self::ITEM_READ, self::CREATE, PlayerInterface::ITEM_READ])]
    #[Assert\Choice(choices: AugmentTypes::ALL)]
    private string $type;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Assert\GreaterThanOrEqual(0)]
    #[Groups([self::ITEM_READ, PlayerInterface::ITEM_READ])]
    private int $price;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups([self::ITEM_READ, PlayerInterface::ITEM_READ])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ, self::CREATE, PlayerInterface::ITEM_READ])]
    private int $validForDays;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ, self::CREATE, PlayerInterface::ITEM_READ])]
    #[Assert\GreaterThanOrEqual(1)]
    private int $multiplier;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoryStatistics', fetch: 'LAZY')]
    #[Groups([self::WRITE, self::ITEM_READ, PlayerInterface::ITEM_READ])]
    private Category $category;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'augments')]
    private PlayerInterface $player;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getCategory(): CategoryInterface
    {
        return $this->category;
    }

    public function setCategory(CategoryInterface $category): void
    {
        $this->category = $category;
    }

    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    public function setPlayer(PlayerInterface $player): void
    {
        $this->player = $player;
    }

    #[Groups([self::ITEM_READ, PlayerInterface::ITEM_READ])]
    public function getValidUntil(): \DateTimeInterface
    {
        return $this->createdAt->modify(sprintf('+%d days', $this->validForDays));
    }

    public function getValidForDays(): int
    {
        return $this->validForDays;
    }

    public function setValidForDays(int $validForDays): void
    {
        $this->validForDays = $validForDays;
    }

    public function getMultiplier(): int
    {
        return $this->multiplier;
    }

    public function setMultiplier(int $multiplier): void
    {
        $this->multiplier = $multiplier;
    }

    #[Groups([PlayerInterface::ITEM_READ, self::ITEM_READ])]
    public function getCategoryName(): string
    {
        return $this->category->getName();
    }
}
