<?php

declare(strict_types=1);

namespace App\Components\Security\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Components\Player\Entity\Player;
use App\Core\Creator\DefaultDataCreator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class PlayerRegistrationProcessor implements ProcessorInterface
{

    public function __construct(
        private ProcessorInterface $processor,
        private DefaultDataCreator $defaultDataCreator,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Player
    {
        if (!$data->getPassword()) {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPassword()
        );

        $this->defaultDataCreator->create($data);

        $data->setPassword($hashedPassword);
        $data->eraseCredentials();

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}