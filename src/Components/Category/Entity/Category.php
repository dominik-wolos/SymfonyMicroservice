<?php

declare(strict_types=1);

namespace App\Components\Category\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\ApiResource\ApiContextGroups;
use App\Components\Statistic\Entity\CategoryStatistic;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\NotNull;

#[ApiResource(
    normalizationContext: ['groups' => [self::SHOW, self::INDEX]],
    denormalizationContext: ['groups' => [self::CREATE, self::UPDATE]]
)]
#[Get(normalizationContext: ['groups' => [self::SHOW]])]
#[GetCollection(normalizationContext: ['groups' => [self::INDEX]])]
#[Post(
    normalizationContext: ['groups' => [self::SHOW]],
    denormalizationContext: ['groups' => [self::CREATE]]
)]
#[Delete(normalizationContext: ['groups' => [self::SHOW]])]
#[ORM\Entity]
class Category implements CategoryInterface, ApiContextGroups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[NotNull()]
    private string $code;

    #[ORM\Column(type: 'string')]
    #[NotNull()]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryStatistic::class)]
    private Collection $categoryStatistics;

    #[Groups([self::SHOW, self::INDEX])]
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    #[Groups([self::SHOW, self::INDEX])]
    public function getName(): string
    {
        return $this->name;
    }

    #[Groups([self::UPDATE, self::CREATE])]
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    #[Groups([self::SHOW, self::INDEX])]
    public function getCode(): string
    {
        return $this->code;
    }
    #[Groups([self::CREATE])]
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    #[Groups([self::SHOW])]
    public function getCategoryStatistics(): Collection
    {
        return $this->categoryStatistics;
    }

    #[Groups([self::EXCLUDED])]
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

    #[Groups([self::EXCLUDED])]
    public function hasCategoryStatistic(CategoryStatistic $categoryStatistic): bool
    {
        return $this->categoryStatistics->contains($categoryStatistic);
    }
}
