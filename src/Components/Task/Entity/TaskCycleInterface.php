<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

interface TaskCycleInterface
{
    public const CREATE = 'task_cycle:create';

    public const WRITE = 'task_cycle:write';

    public const READ = 'task_cycle:read';

    public const ITEM_READ = 'task_cycle:item:read';

    public function getId(): int;

    public function getUnit(): string;

    public function setUnit(string $unit): void;

    public function getInterval(): int;

    public function setInterval(int $interval): void;

    public function getStartAt(): \DateTimeInterface;

    public function setStartAt(\DateTimeInterface $startAt): void;

    public function getEndAt(): \DateTimeInterface;

    public function setEndAt(\DateTimeInterface $endAt): void;

    public function getCreatedAt(): \DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $createdAt): void;
}
