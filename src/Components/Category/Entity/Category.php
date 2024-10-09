<?php

declare(strict_types=1);

namespace App\Components\Category\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Statistic\Entity\CategoryStatistic;
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
    normalizationContext: ['groups' => ['category:read']],
    denormalizationContext: ['groups' => ['category:write']]
)]
#[ORM\Entity]
class Category implements CategoryInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[NotNull]
    #[Groups([self::ITEM_READ, self::CREATE])]
    #[Assert\Unique]
    private string $code;

    #[ORM\Column(type: 'string')]
    #[NotNull]
    #[Groups([self::ITEM_READ , self::WRITE])]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryStatistic::class)]
    #[Groups([self::READ, self::WRITE])]
    #[Assert\Valid]
    private Collection $categoryStatistics;

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
        if ($this->hasCategoryStatistic($categoryStatistic)) {
            return;
        }

        $this->categoryStatistics->add($categoryStatistic);
    }

    public function removeCategoryStatistic(CategoryStatistic $categoryStatistic): void
    {
        if (!$this->hasCategoryStatistic($categoryStatistic)) {
            return;
        }

        $this->categoryStatistics->removeElement($categoryStatistic);
    }
}
