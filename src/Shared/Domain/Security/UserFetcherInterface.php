<?php

declare(strict_types=1);

namespace App\Shared\Domain\Security;

/**
 * Интерфейс возвращающий информацию о текущем авторизованном пользователе.
 */
interface UserFetcherInterface
{
    public function getAuthUser(): AuthUserInterface;
}
