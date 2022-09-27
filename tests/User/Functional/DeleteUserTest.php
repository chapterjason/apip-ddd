<?php

declare(strict_types=1);

namespace App\Tests\User\Functional;

use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\User\DummyFactory\DummyUserFactory;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Domain\Repository\UserRepositoryInterface;
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
