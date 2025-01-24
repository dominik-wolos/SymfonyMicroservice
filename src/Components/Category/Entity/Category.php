<?php

declare(strict_types=1);

namespace App\Components\Category\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\DataProvider\DirectPlayerResourceInterface;
use App\Components\Category\Processor\CategoryProcessor;
use App\Components\Player\Entity\Player;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Shop\Entity\AugmentInterface;
use App\Components\Statistic\Entity\CategoryStatistic;
use App\Components\Statistic\Entity\CategoryStatisticInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotNull;

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
            ]],
            processor: CategoryProcessor::class
        ),
        new Patch(
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ
            ]],
            denormalizationContext: ['groups' => [
                self::WRITE,
                self::UPDATE
            ]],
            processor: CategoryProcessor::class
        ),
        new Delete()
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE]],
)]
#[ORM\Entity]
class Category implements CategoryInterface, DirectPlayerResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([
        self::ITEM_READ,
        PlayerInterface::ITEM_READ,
        AugmentInterface::ITEM_READ
    ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::ITEM_READ])]
    private string $code;

    #[ORM\Column(type: 'string')]
    #[NotNull]
    #[Groups([
        self::ITEM_READ ,
        self::WRITE,
        PlayerInterface::ITEM_READ,
        AugmentInterface::ITEM_READ
    ])]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryStatistic::class, cascade: ['remove'])]
    #[Groups([self::READ])]
    #[Assert\Valid]
    private Collection $categoryStatistics;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    private Player $player;

    private array $statisticsIds = [];

    public function __construct()
    {
        $this->categoryStatistics = new ArrayCollection();
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getCategoryStatistics(): Collection
    {
        return $this->categoryStatistics;
    }

    public function setCategoryStatistics(Collection $categoryStatistics): void
    {
        $this->categoryStatistics = $categoryStatistics;
    }

    public function addCategoryStatistic(CategoryStatistic $categoryStatistic): void
    {
        if ($this->categoryStatistics->contains($categoryStatistic)) {
            return;
        }

        $this->categoryStatistics->add($categoryStatistic);
    }

    public function removeCategoryStatistic(CategoryStatistic $categoryStatistic): void
    {
        if (!$this->categoryStatistics->contains($categoryStatistic)) {
            return;
        }

        $this->categoryStatistics->removeElement($categoryStatistic);
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function getStatisticsIds(): array
    {
        return $this->statisticsIds;
    }

    #[Groups([self::WRITE])]
    public function setStatisticsIds(array $statistics): void
    {
        $this->statisticsIds = $statistics;
    }

    #[Groups([self::ITEM_READ])]
    public function getCategoryStatisticByStatisticId(int $removeId): ?CategoryStatisticInterface
    {
        foreach ($this->categoryStatistics as $categoryStatistic) {
            if ($categoryStatistic->getStatisticId() === $removeId) {
                return $categoryStatistic;
            }
        }

        return null;
    }

    #[Groups([self::ITEM_READ])]
    public function getStatistics(): array
    {
        return array_map(function (CategoryStatisticInterface $categoryStatistic) {
            return $categoryStatistic->getStatistic();
        }, $this->categoryStatistics->toArray());
    }
}
