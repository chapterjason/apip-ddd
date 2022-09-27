<?php

declare(strict_types=1);

namespace App\Tests\User\Functional;

use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\User\DummyFactory\DummyUserFactory;
use App\User\Application\Query\FindUserQuery;
use App\User\Domain\Repository\UserRepositoryInterface;
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
