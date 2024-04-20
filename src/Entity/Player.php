<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

class Player
{
    private int $id;

    private User $user;

    private string $name;

    /**
     * @var Collection|Player[]
     */
    private Collection $friends;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function setFriends(Collection $friends): void
    {
        $this->friends = $friends;
    }

    public function addFriend(Player $friend): void
    {
        if ($this->hasFriend($friend)) {
            return;
        }

        $this->friends->add($friend);
    }

    public function removeFriend(Player $friend): void
    {
        if (!$this->hasFriend($friend)) {
            return;
        }

        $this->friends->removeElement($friend);
    }

    public function hasFriend(Player $friend): bool
    {
        return $this->friends->contains($friend);
    }
}
