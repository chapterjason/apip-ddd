<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Command;

use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\IdentityIntegration\Application\Event\UserCreatedEvent;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

final class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = new User(
            $command->email,
        );

        $this->userRepository->save($user);

        $this->eventBus->dispatch(
            new UserCreatedEvent(
                $user->id,
                $user->email,
            )
        );

        return $user;
    }
}
