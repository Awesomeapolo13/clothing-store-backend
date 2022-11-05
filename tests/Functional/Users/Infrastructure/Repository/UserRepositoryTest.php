<?php

namespace Functional\Users\Infrastructure\Repository;

use App\Users\Domain\Factory\UserFactory;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Users\Infrastructure\Repository\UserRepository;

/**
 * Функциональные тесты репозитория
 */
class UserRepositoryTest extends WebTestCase
{
    private UserRepository $repository;
    private Generator $faker;

    /**
     * Задает переменные для теста
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->faker = Factory::create();
    }

    /**
     * Тестирование добавления пользователя в репозиторий
     */
    public function test_user_added_successfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = (new UserFactory())
            ->create(
                $email,
                $password
            );

        // act - создаем пользователя
        $this->repository->add($user);

        //assert - проверяем был ли создан пользователь
        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }
}
