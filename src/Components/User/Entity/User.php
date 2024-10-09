<?php

declare(strict_types=1);

namespace App\Components\User\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Components\Player\Entity\Settings;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
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
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups([self::READ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::CREATE, self::ITEM_READ])]
    private string $email;

    #[ORM\Column(type: 'string')]
    #[Groups([self::CREATE])]
    private string $password;

    #[ORM\Column(type: 'string')]
    #[Groups([self::CREATE])]
    private string $salt;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private bool $enabled = true;

    #[ORM\OneToOne(targetEntity: Settings::class)]
    #[Groups([self::READ, self::WRITE])]
    private Settings $playerSettings;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getPlayerSettings(): Settings
    {
        return $this->playerSettings;
    }

    public function setPlayerSettings(Settings $playerSettings): void
    {
        $this->playerSettings = $playerSettings;
    }
}
