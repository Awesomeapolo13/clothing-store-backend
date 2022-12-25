<?php

declare(strict_types=1);

namespace App\Shared\Domain\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Интерфейс авторизованного пользователя.
 */
interface AuthUserInterface extends UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Получение идетнификатора пользователя.
     */
    public function getUlid(): string;

    /**
     * Получение почты пользователя.
     */
    public function getEmail(): string;
}
