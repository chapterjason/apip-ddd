<?php

declare(strict_types=1);

namespace App\Tests\Identity\User\Functional;

use App\Identity\User\Application\Query\FindUserQuery;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Identity\User\DummyFactory\DummyUserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FindUserTest extends KernelTestCase
{
    public function testFindUser(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $user = DummyUserFactory::createUser();
        $userRepository->save($user);

        static::assertSame($user, $queryBus->ask(new FindUserQuery($user->id)));
    }
}
