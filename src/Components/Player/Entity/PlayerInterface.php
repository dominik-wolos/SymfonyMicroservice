<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Task\Entity\RewardItem;
use App\Components\User\Entity\User;
use Doctrine\Common\Collections\Collection;

interface PlayerInterface
{
    public const CREATE = 'player:create';

    public const WRITE = 'player:write';

    public const READ = 'player:read';

    public const ITEM_READ = 'player:item:read';

    public const UPDATE = 'player:update';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getUser(): User;

    public function setUser(User $user): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getObtainedRewards(): Collection;

    public function addObtainedReward(RewardItem $rewardItem): void;

    public function removeObtainedReward(RewardItem $rewardItem): void;
}
