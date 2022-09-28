<?php

declare(strict_types=1);

namespace App\Tests\Identity\User\Functional;

use App\Identity\User\Application\Query\FindUsersQuery;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Identity\User\DummyFactory\DummyUserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FindUsersTest extends KernelTestCase
{
    public function testFindUsers(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $initialUsers = [
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
        ];

        foreach ($initialUsers as $user) {
            $userRepository->save($user);
        }

        $users = $queryBus->ask(new FindUsersQuery());

        static::assertCount(count($initialUsers), $users);
        foreach ($users as $user) {
            static::assertContains($user, $initialUsers);
        }
    }

    public function testReturnPaginatedUsers(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $initialUsers = [
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
        ];

        foreach ($initialUsers as $user) {
            $userRepository->save($user);
        }

        $users = $queryBus->ask(new FindUsersQuery(page: 2, itemsPerPage: 2));

        static::assertCount(2, $users);
        $i = 0;
        foreach ($users as $user) {
            static::assertSame($initialUsers[$i + 2], $user);
            ++$i;
        }
    }
}
