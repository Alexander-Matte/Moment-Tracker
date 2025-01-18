<?php
// api/src/State/UserPasswordHasher.php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;  // Use App\Entity\User directly

/**
 * @implements ProcessorInterface<User, User|void>
 */
final class UserPasswordHasher implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $processor,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    /**
     * @param User $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        // Check if plain password is set
        if ($data->getPlainPassword()) {
            // Hash the password
            $hashedPassword = $this->passwordHasher->hashPassword(
                $data,
                $data->getPlainPassword()
            );
            $data->setPassword($hashedPassword);
            $data->eraseCredentials();  // Remove plain password from the entity
        }

        // Process using the next processor in the chain (i.e., persist to the database)
        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
