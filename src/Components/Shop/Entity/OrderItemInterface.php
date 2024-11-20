<?php

declare(strict_types=1);

namespace App\Components\Shop\Entity;

interface OrderItemInterface
{
    public const CREATE = 'order_item:create';

    public const WRITE = 'order_item:write';

    public const READ = 'order_item:read';

    public const ITEM_READ = 'order_item:item:read';

    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getPrice(): int;

    public function setPrice(int $price): void;

    public function getProduct(): ProductInterface;

    public function setProduct(ProductInterface $product): void;

    public function getBoughAt(): \DateTimeImmutable;

    public function setBoughAt(\DateTimeImmutable $boughAt): void;

    public function getValidThrough(): int;

    public function setValidThrough(int $validThrough): void;
}