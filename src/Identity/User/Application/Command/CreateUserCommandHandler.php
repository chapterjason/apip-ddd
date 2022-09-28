<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Command;

use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = new User(
            $command->email,
        );

        $this->userRepository->save($user);

        return $user;
    }
}
