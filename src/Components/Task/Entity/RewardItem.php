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
#[ORM\Table(name: 'reward_item')]
class RewardItem implements RewardItemInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups([self::ITEM_READ])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups([self::ITEM_READ, self::CREATE])]
    private string $code;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $type;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $name;

    #[ORM\Column(type: 'text')]
    #[Groups([self::READ, self::WRITE])]
    private string $description;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
