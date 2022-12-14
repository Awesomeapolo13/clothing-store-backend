<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Функциональные тесты репозитория.
 */
class UserRepositoryTest extends WebTestCase
{
    private UserRepository $repository;
    private UserFactory $userFactory;
    private Generator $faker;
    private AbstractDatabaseTool $databaseTool;

    /**
     * Задает переменные для теста.
     *
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->userFactory = static::getContainer()->get(UserFactory::class);
        $this->faker = Factory::create();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    /**
     * Тестирование добавления пользователя в БД чеерз репозиторий.
     */
    public function test_user_added_successfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = $this
            ->userFactory
            ->create(
                $email,
                $password
            );

        // act - создаем пользователя
        $this->repository->add($user);

        // assert - проверяем был ли создан пользователь
        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }

    public function test_user_found_successfully(): void
    {
        // arrange - подготовка
        $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
        $user = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE);

        // act
        $existingUser = $this->repository->findByUlid($user->getUlid());

        // assert
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }
}
