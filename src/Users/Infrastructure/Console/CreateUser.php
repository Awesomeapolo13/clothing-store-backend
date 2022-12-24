<?php

namespace App\Users\Infrastructure\Console;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

/**
 * Команда создания нового пользователя
 */
#[AsCommand(
    name: 'app:users:create-user',
    description: 'create-user'
)]
final class CreateUser extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);
        // Получаем на вход почту пользователя
        $email = $io->ask(
            'email',
            null,
            function (?string $input) {
                // Валидация Email
                Assert::email($input, 'Email is invalid');

                return $input;
            }
        );
        // Получаем на вход пароль пользователя
        $password = $io->askHidden(
            'password',
            function (?string $input) {
                // Валидация пароля
                Assert::notEmpty($input, 'Password cannot be empty');

                return $input;
            }
        );
        // Получаем пользователя на фабрике и добавляем его в репозиторий
        $user = $this->userFactory->create($email, $password);
        $this->userRepository->add($user);

        return Command::SUCCESS;
    }
}
