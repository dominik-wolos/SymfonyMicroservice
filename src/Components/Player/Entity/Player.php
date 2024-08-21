<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\User\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'player')]
class Player implements PlayerInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\Column(type: 'string', unique: true)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Player::class)]
    #[ORM\JoinTable(name: 'player_friend')]
    private Collection $friends;

    public function getId(): ?int
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

    public function addFriend(self $friend): void
    {
        if ($this->hasFriend($friend)) {
            return;
        }

        $this->friends->add($friend);
    }

    public function removeFriend(self $friend): void
    {
        if (!$this->hasFriend($friend)) {
            return;
        }

        $this->friends->removeElement($friend);
    }

    public function hasFriend(self $friend): bool
    {
        return $this->friends->contains($friend);
    }
}
