<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Service\UlidService;
use App\Users\Domain\Service\UserPasswordHasherInterface;

class User implements AuthUserInterface
{
    private string $ulid;
    private string $email;
    /**
     * Возможен null, например, в случае аутентификации через соц сети.
     */
    private ?string $password = null;

    public function __construct(string $email)
    {
        $this->ulid = UlidService::generate();
        $this->email = $email;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Возвращает информацию о ролях пользователя.
     */
    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    /**
     * Очищает чувствительные данные (например пароль)
     * Т.к. он реализуется в сущности, то использовать не рекомендуется (есть угроза удаления пользовательского пароля).
     */
    public function eraseCredentials()
    {
    }

    /**
     * Возвращает электронную почту в качестве идентификатора.
     */
    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    /**
     * Сеттер пароля с хешированием
     */
    public function setPassword(?string $password, UserPasswordHasherInterface $passwordHasher): void
    {
        $this->password = is_null($password)
            ?
            null
            :
            $passwordHasher->hash(
                $this,
                $password
            );
    }
}
