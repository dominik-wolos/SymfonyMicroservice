<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Player\Entity\PlayerStatistics;
use App\Components\Statistic\Processor\StatisticCreationProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
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
            processor: StatisticCreationProcessor::class,
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
#[ORM\Entity(repositoryClass: 'App\Components\Statistic\Repository\StatisticRepository')]
#[ORM\Table(name: 'statistic')]
class Statistic implements StatisticInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ, PlayerInterface::ITEM_READ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::ITEM_READ])]
    private string $code;

    #[ORM\Column(type: 'string')]
    #[Groups([self::ITEM_READ, self::WRITE, PlayerInterface::ITEM_READ])]
    private string $name;

    #[ORM\Column(type: 'string')]
    #[Groups([self::ITEM_READ, self::WRITE, PlayerInterface::ITEM_READ])]
    private string $iconPath = 'determination_bar';

    #[ORM\ManyToOne(targetEntity: PlayerStatistics::class, inversedBy: 'statistics', fetch: 'LAZY')]
    private PlayerStatistics $playerStatistics;

    #[ORM\Column(type: 'integer')]
    #[Groups([self::ITEM_READ, PlayerInterface::ITEM_READ])]
    private int $experience = 0;

    #[ORM\Column(type: 'integer')]
    #[Groups([self::ITEM_READ, PlayerInterface::ITEM_READ])]
    private int $level = 1;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerStatistics(): PlayerStatistics
    {
        return $this->playerStatistics;
    }

    public function setPlayerStatistics(PlayerStatistics $playerStatistics): void
    {
        $this->playerStatistics = $playerStatistics;
        if (!$playerStatistics->hasStatistic($this)) {
            $playerStatistics->addStatistic($this);
        }
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): void
    {
        $this->experience = $experience;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIconPath(): string
    {
        return $this->iconPath;
    }

    public function setIconPath(string $iconPath): void
    {
        $this->iconPath = $iconPath;
    }
}
