<?php

declare(strict_types=1);

namespace App\Components\Shop\Entity;

use Doctrine\Common\Collections\Collection;

interface OrderInterface
{
    public const CREATE = 'user:create';

    public const WRITE = 'user:write';

    public const READ = 'user:read';

    public const ITEM_READ = 'user:item:read';

    public const UPDATE = 'user:update';

    public const STATUS_NEW = 'new';

    public const STATUS_PAID = 'paid';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_PAID,
    ];

    public function getId(): int;

    public function setId(int $id): void;

    public function getStatus(): string;

    public function setStatus(string $status): void;

    public function getTotal(): int;

    public function setTotal(int $total): void;

    public function getPlacedAt(): \DateTimeImmutable;

    public function setPlacedAt(\DateTimeImmutable $placedAt): void;

    public function getItems(): Collection;

    public function setItems(Collection $items): void;

    public function isPaid(): bool;
}
