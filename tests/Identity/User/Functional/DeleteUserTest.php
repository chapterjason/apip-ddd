<?php

declare(strict_types=1);

namespace App\Tests\Identity\User\Functional;

use App\Identity\User\Application\Command\DeleteUserCommand;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\Identity\User\DummyFactory\DummyUserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DeleteUserTest extends KernelTestCase
{
    public function testDeleteUser(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        $user = DummyUserFactory::createUser();
        $userRepository->save($user);

        static::assertCount(1, $userRepository);

        $commandBus->dispatch(new DeleteUserCommand($user->id));

        static::assertEmpty($userRepository);
    }
}
