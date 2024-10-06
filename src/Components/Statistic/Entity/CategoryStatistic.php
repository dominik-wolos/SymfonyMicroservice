<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Components\Category\Entity\Category;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity]
#[ORM\Table(name: 'category_statistic')]
class CategoryStatistic implements CategoryStatisticInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoryStatistics', fetch: 'LAZY')]
    private Category $category;

    #[ORM\OneToOne(targetEntity: Statistic::class)]
    private Statistic $statistic;

    #[ORM\Column(type: 'integer')]
    private int $multiplier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getStatistic(): Statistic
    {
        return $this->statistic;
    }

    public function setStatistic(Statistic $statistic): void
    {
        $this->statistic = $statistic;
    }

    public function getMultiplier(): int
    {
        return $this->multiplier;
    }

    public function setMultiplier(int $multiplier): void
    {
        $this->multiplier = $multiplier;
    }
}
