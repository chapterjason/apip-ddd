<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Command;

use App\Identity\User\Domain\Exception\MissingUserException;
use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $this->userRepository->ofId($command->id);

        if (null === $user) {
            throw new MissingUserException($command->id);
        }

        $user->email = $command->email ?? $user->email;

        $this->userRepository->save($user);

        return $user;
    }
}
