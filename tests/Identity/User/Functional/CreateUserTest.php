<?php

declare(strict_types=1);

namespace App\Tests\Identity\User\Functional;

use App\Identity\User\Application\Command\CreateUserCommand;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Identity\User\Domain\ValueObject\UserEmail;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CreateUserTest extends KernelTestCase
{
    public function testCreateUser(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        static::assertEmpty($userRepository);

        $commandBus->dispatch(new CreateUserCommand(
            new UserEmail('foo@test.com'),
        ));

        static::assertCount(1, $userRepository);

        $user = array_values(iterator_to_array($userRepository))[0];

        static::assertEquals(new UserEmail('foo@test.com'), $user->email);
    }
}
