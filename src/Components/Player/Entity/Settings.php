<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\User\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Valid;

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
#[ORM\Table(name: 'player_settings')]
class Settings implements SettingsInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::ITEM_READ])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[Valid]
    #[Groups([self::ITEM_READ, self::CREATE])]
    private ?User $user;

    #[ORM\Column(type: 'string', unique: false)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $notificationSettings;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private bool $holidayMode;

    #[ORM\Column(type: 'string', options: ['default' => 'en'])]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private string $languagePreferences;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private bool $darkMode;

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

    public function getNotificationSettings(): string
    {
        return $this->notificationSettings;
    }

    public function setNotificationSettings(string $notificationSettings): void
    {
        $this->notificationSettings = $notificationSettings;
    }

    public function isHolidayMode(): bool
    {
        return $this->holidayMode;
    }

    public function setHolidayMode(bool $holidayMode): void
    {
        $this->holidayMode = $holidayMode;
    }

    public function getLanguagePreferences(): string
    {
        return $this->languagePreferences;
    }

    public function setLanguagePreferences(string $languagePreferences): void
    {
        $this->languagePreferences = $languagePreferences;
    }

    public function isDarkMode(): bool
    {
        return $this->darkMode;
    }

    public function setDarkMode(bool $darkMode): void
    {
        $this->darkMode = $darkMode;
    }
}
