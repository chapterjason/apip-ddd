<?php

declare(strict_types=1);

namespace App\Tests\User\Functional;

use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\User\DummyFactory\DummyUserFactory;
use App\User\Application\Command\UpdateUserCommand;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\ValueObject\UserEmail;
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
