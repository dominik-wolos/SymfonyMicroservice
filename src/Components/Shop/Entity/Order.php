<?php

declare(strict_types=1);

namespace App\Components\Shop\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\Collection;
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
#[ORM\Table(name: 'shop_order')]
class Order implements OrderInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private int $id;

    #[ORM\Column(type: 'string', length: 15)]
    #[Assert\Length(min: 3, max: 15)]
    #[Assert\AtLeastOneOf([
        new Assert\IdenticalTo(self::STATUS_NEW),
        new Assert\IdenticalTo(self::STATUS_PAID),
    ])]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $status;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Assert\GreaterThan(0)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private int $total;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private \DateTimeImmutable $placedAt;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order')]
    #[Assert\Valid]
    #[Groups([self::READ, self::WRITE])]
    private Collection $items;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function getPlacedAt(): \DateTimeImmutable
    {
        return $this->placedAt;
    }

    public function setPlacedAt(\DateTimeImmutable $placedAt): void
    {
        $this->placedAt = $placedAt;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }

    public function isPaid(): bool
    {
        return self::STATUS_PAID === $this->status;
    }
}
