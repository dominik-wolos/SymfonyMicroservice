<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Category\Entity\Category;
use App\Components\Shop\Entity\Augment;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

interface PlayerInterface extends UserInterface, PasswordAuthenticatedUserInterface
{
    public const CREATE = 'player:create';

    public const WRITE = 'player:write';

    public const READ = 'player:read';

    public const ITEM_READ = 'player:item:read';

    public const UPDATE = 'player:update';

    public const REGISTER = 'player:register';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getPassword(): string;

    public function setPassword(string $password): void;

    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): void;

    public function getPlayerStatistics(): PlayerStatisticsInterface;

    public function setPlayerStatistics(PlayerStatisticsInterface $playerStatistics): void;

    public function getPlayerLevel(): int;

    public function setPlayerLevel(int $playerLevel): void;

    public function getPlayerExperience(): int;

    public function setPlayerExperience(int $playerExperience): void;

    public function getUserPhotoPath(): ?string;

    public function setUserPhotoPath(?string $userPhotoPath): void;

    public function getBalance(): int;

    public function getActiveAugments(): array;

    public function getCategories(): Collection;

    public function getAugments(): Collection;

    public function setAugments(Collection $augments): void;

    public function getWallet(): WalletInterface;

    public function setWallet(WalletInterface $wallet): void;

    public function addCategory(Category $category): void;
}
