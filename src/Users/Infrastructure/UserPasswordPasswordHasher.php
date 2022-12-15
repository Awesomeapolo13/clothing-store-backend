<?php

namespace App\Users\Infrastructure;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as BaseUserHasherInterface;

class UserPasswordPasswordHasher implements UserPasswordHasherInterface
{
    public function __construct(
        private readonly BaseUserHasherInterface $passwordHasher
    )
    {
    }

    public function hash(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }
}
