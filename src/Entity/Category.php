<?php

declare(strict_types=1);

namespace App\Components\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
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
    normalizationContext: [
        'groups' => [
            self::SHOW,
            self::INDEX,
        ]
    ],
    denormalizationContext: [
        'groups' => [
            self::CREATE,
            self::UPDATE
        ]
    ]
)]
#[ORM\Entity]
class Categorysys implements ApiContextGroups
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

    #[Groups([self::SHOW])]
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    #[Groups([self::SHOW])]
    public function getName(): string
    {
        return $this->name;
    }

    #[Groups([self::UPDATE, self::CREATE])]
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    #[Groups([self::SHOW, self::CREATE])]
    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
