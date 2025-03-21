<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\Controller\ResetPassword\ChangePasswordAction;
use App\Api\Controller\ResetPassword\InitializeResetPasswordAction;
use App\Api\Controller\ResetPassword\VerificationCodeAction;
use App\Api\Provider\CurrentPlayerProvider;
use App\Components\Achievement\Entity\Achievement;
use App\Components\Category\Entity\Category;
use App\Components\Security\Processor\PlayerRegistrationProcessor;
use App\Components\Shop\Entity\Augment;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\NotNull;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/initialize-reset-password',
            controller: InitializeResetPasswordAction::class,
            openapiContext: [
                'summary' => 'Initialize the password reset process',
                'description' => 'Sends an email with a verification code to the user',
            ],
            read: false,
            deserialize: false,
            serialize: false,
        ),
        new Post(
            uriTemplate: '/reset-password/{verificationCode}',
            controller: VerificationCodeAction::class,
            openapiContext: [
                'summary' => 'Validates code sent by user',
            ],
            read: false,
            deserialize: false,
            serialize: false,
        ),
        new Post(
            uriTemplate: '/change-password/{token}',
            controller: ChangePasswordAction::class,
            openapiContext: [
                'summary' => 'Change the user’s password',
                'description' => 'Changes the user’s password',
            ],
            read: false,
            deserialize: false,
            serialize: false,
        ),
    ],
)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/player-from-token',
            openapiContext: [
                'summary' => 'Retrieve the authenticated user’s information',
                'description' => 'Returns information about the authenticated user',
            ],
            normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
            provider: CurrentPlayerProvider::class,
        ),
    ],
)]
#[ApiResource(
    uriTemplate: '/register',
    operations: [
        new Post(
            normalizationContext: ['groups' => [
                self::REGISTER,
            ],
            ],
            denormalizationContext: ['groups' => [
                self::CREATE,
                self::WRITE,
            ]],
            processor: PlayerRegistrationProcessor::class,
        ),
    ],
    normalizationContext: ['groups' => [self::REGISTER]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE]],
)]
#[ApiResource(
    operations: [
        new Patch(
            normalizationContext: ['groups' => [
                self::READ,
                self::ITEM_READ,
            ]],
            denormalizationContext: ['groups' => [
                self::UPDATE,
            ]],
        ),
        new Delete(),
    ],
    normalizationContext: ['groups' => [self::READ, self::ITEM_READ]],
    denormalizationContext: ['groups' => [self::WRITE, self::CREATE]],
)]
#[ORM\Entity]
#[ORM\Table(name: 'player')]
#[UniqueEntity(fields: ['email'], message: 'This email is already in use.')]
#[UniqueEntity(fields: ['name'], message: 'This username is already in use.')]
class Player implements PlayerInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups(self::ITEM_READ)]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::ITEM_READ, self::WRITE])]
    #[NotNull()]
    private string $name;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups([self::CREATE, self::ITEM_READ])]
    private string $email;

    #[ORM\Column(type: 'string')]
    #[Groups([self::CREATE])]
    private string $password;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    #[Groups([self::ITEM_READ])]
    private bool $enabled = true;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    #[Groups([self::ITEM_READ, self::WRITE])]
    private bool $vacations = true;

    #[ORM\Column(type: 'json')]
    #[Groups([self::ITEM_READ])]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    #[Groups([self::ITEM_READ])]
    private int $playerLevel = 1;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    #[Groups([self::ITEM_READ])]
    private int $playerExperience = 0;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    #[Groups([self::ITEM_READ])]
    private int $completedTasks = 0;

    #[ORM\Column(type: 'string', nullable: true, options: ['default' => ''])]
    #[Groups([self::ITEM_READ, self::UPDATE])]
    private ?string $userPhotoPath;

    #[ORM\OneToOne(targetEntity: PlayerStatistics::class, cascade: ['persist', 'remove'])]
    #[Groups([self::ITEM_READ])]
    private PlayerStatisticsInterface $playerStatistics;

    #[ORM\OneToMany(targetEntity: Augment::class, mappedBy: 'player', fetch: 'LAZY')]
    private Collection $augments;

    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'player', fetch: 'LAZY')]
    #[Groups([self::ITEM_READ])]
    private Collection $categories;

    #[ORM\OneToOne(targetEntity: Wallet::class, cascade: ['persist', 'remove'])]
    private WalletInterface $wallet;

    #[ORM\OneToMany(targetEntity: Achievement::class, mappedBy: 'player', fetch: 'LAZY')]
    #[Groups([self::ITEM_READ])]
    private Collection $achievements;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $verificationCode = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $resetPasswordToken = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $resetPasswordTokenValidUntil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPlayerStatistics(): PlayerStatisticsInterface
    {
        return $this->playerStatistics;
    }

    public function setPlayerStatistics(PlayerStatisticsInterface $playerStatistics): void
    {
        $this->playerStatistics = $playerStatistics;
    }

    public function getPlayerLevel(): int
    {
        return $this->playerLevel;
    }

    public function setPlayerLevel(int $playerLevel): void
    {
        $this->playerLevel = $playerLevel;
    }

    public function getPlayerExperience(): int
    {
        return $this->playerExperience;
    }

    public function setPlayerExperience(int $playerExperience): void
    {
        $this->playerExperience = $playerExperience;
    }

    public function addExperience(int $playerExperience): void
    {
        $this->playerExperience += $playerExperience;

        if ($this->playerExperience >= self::LEVEL_TO_EXPERIENCE_MAP[$this->playerLevel]) {
            $this->playerExperience -= self::LEVEL_TO_EXPERIENCE_MAP[$this->playerLevel];
            ++$this->playerLevel;
        }
    }

    public function getUserPhotoPath(): ?string
    {
        return $this->userPhotoPath;
    }

    public function setUserPhotoPath(?string $userPhotoPath): void
    {
        $this->userPhotoPath = $userPhotoPath;
    }

    #[Groups([self::ITEM_READ])]
    public function getBalance(): int
    {
        return $this->wallet->getBalance();
    }

    #[Groups([self::ITEM_READ])]
    public function getActiveAugments(): array
    {
        return array_values(
            $this->augments->filter(
                fn (Augment $augment) => new \DateTime() < $augment->getValidUntil(),
            )->toArray(),
        );
    }

    #[Groups([self::ITEM_READ])]
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function getAugments(): Collection
    {
        return $this->augments;
    }

    public function setAugments(Collection $augments): void
    {
        $this->augments = $augments;
    }

    public function getWallet(): WalletInterface
    {
        return $this->wallet;
    }

    public function setWallet(WalletInterface $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function addCategory(Category $category): void
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->categories->add($category);
    }

    public function getCompletedTasks(): int
    {
        return $this->completedTasks;
    }

    public function incrementCompletedTasks(): void
    {
        ++$this->completedTasks;
    }

    public function getAchievements(): Collection
    {
        return $this->achievements;
    }

    public function setAchievements(Collection $achievements): void
    {
        $this->achievements = $achievements;
    }

    public function getAchievementById(int $id): ?Achievement
    {
        foreach ($this->achievements as $achievement) {
            if ($achievement->getId() === $id) {
                return $achievement;
            }
        }

        return null;
    }

    public function getVerificationCode(): ?int
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(?int $verificationCode): void
    {
        $this->verificationCode = $verificationCode;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken): void
    {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    public function getResetPasswordTokenValidUntil(): ?\DateTime
    {
        return $this->resetPasswordTokenValidUntil;
    }

    public function setResetPasswordTokenValidUntil(?\DateTime $resetPasswordTokenValidUntil): void
    {
        $this->resetPasswordTokenValidUntil = $resetPasswordTokenValidUntil;
    }

    public function isVacations(): bool
    {
        return $this->vacations;
    }

    public function setVacations(bool $vacations): void
    {
        $this->vacations = $vacations;
    }
}
