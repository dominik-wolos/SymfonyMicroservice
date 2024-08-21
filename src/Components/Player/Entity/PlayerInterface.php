<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\User\Entity\User;
use Doctrine\Common\Collections\Collection;

interface PlayerInterface
{
    public function getId(): ?int;

    public function setId(int $id): void;

    public function getUser(): User;

    public function setUser(User $user): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getFriends(): Collection;

    public function setFriends(Collection $friends): void;

    public function addFriend(Player $friend): void;

    public function removeFriend(Player $friend): void;

    public function hasFriend(Player $friend): bool;
}
