<?php

declare(strict_types=1);

namespace App\Tests\Identity\User\Functional;

use App\Identity\User\Application\Command\UpdateUserCommand;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Identity\User\Domain\ValueObject\UserEmail;
use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\Identity\User\DummyFactory\DummyUserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UpdateUserTest extends KernelTestCase
{
    public function testUpdateUser(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        $initialUser = DummyUserFactory::createUser(
            email: 'bar@test.com',
        );

        $userRepository->save($initialUser);

        $commandBus->dispatch(new UpdateUserCommand(
            $initialUser->id,
            email: new UserEmail('foo@test.com'),
        ));

        $user = $userRepository->ofId($initialUser->id);

        static::assertEquals(new UserEmail('foo@test.com'), $user->email);
    }
}
