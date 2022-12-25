<?php

namespace App\Tests\Functional\Users\Infrastructure\Controller;

use App\Tests\Tools\FixtureTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetMeActionTest extends WebTestCase
{
    use FixtureTools;

    public function test_get_me_action(): void
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();
        // Выполняем запрос на аутентификацию
        $client->request(
            'POST',
            '/api/auth/token/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ]),
        );
        // Получаем результат запроса
        $data = json_decode(
            $client
                ->getResponse()
                ->getContent(),
            true
        );
        // Извлекаем из ответа токен
        $client->getServerParameter(
            'HTTP_AUTHORIZATION',
            sprintf(
                'Bearer %s',
                $data['token']
            )
        );
        // act Выполняем запрос получения информации об авторизованном ползователе
        $client->request('GET', '/api/users/me');
        /*
         * assert Проверяем утверждение, что почта пользователя, полученного по эндоинту соответствует той,
         * с помощью которой происходила авторизация
         */
        $data = json_decode(
            $client
                ->getResponse()
                ->getContent(),
            true
        );
        $this->assertEquals(
            $user->getEmail(),
            $data['email']
        );
    }
}
