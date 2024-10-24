<?php

declare(strict_types=1);

namespace App\Components\Shop\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'order_item')]
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
class OrderItem implements OrderItemInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private int $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 30)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $name;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Assert\GreaterThanOrEqual(0)]
    #[Groups([self::ITEM_READ])]
    private int $price;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Assert\Valid]
    private ProductInterface $product;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups([self::ITEM_READ])]
    private \DateTimeImmutable $boughAt;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private int $validThrough;

    #[ORM\Column(type: 'boolean')]
    #[Groups([self::ITEM_READ])]
    private bool $isPaid = false;

    public function __construct()
    {
        $this->boughAt = new \DateTimeImmutable();
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

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getBoughAt(): \DateTimeImmutable
    {
        return $this->boughAt;
    }

    public function setBoughAt(\DateTimeImmutable $boughAt): void
    {
        $this->boughAt = $boughAt;
    }

    public function getValidThrough(): int
    {
        return $this->validThrough;
    }

    public function setValidThrough(int $validThrough): void
    {
        $this->validThrough = $validThrough;
    }

    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }
}
