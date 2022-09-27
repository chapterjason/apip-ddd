<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Domain\Exception\MissingUserException;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;

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
