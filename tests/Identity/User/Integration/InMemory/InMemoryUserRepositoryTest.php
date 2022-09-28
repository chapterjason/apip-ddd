<?php

declare(strict_types=1);

namespace App\Tests\Identity\User\Integration\InMemory;

use App\Identity\User\Infrastructure\InMemory\InMemoryUserRepository;
use App\Shared\Infrastructure\InMemory\InMemoryPaginator;
use App\Tests\Identity\User\DummyFactory\DummyUserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class InMemoryUserRepositoryTest extends KernelTestCase
{
    public function testAdd(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);

        static::assertEmpty($repository);

        $user = DummyUserFactory::createUser();
        $repository->save($user);

        static::assertCount(1, $repository);
    }

    public function testRemove(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);

        $user = DummyUserFactory::createUser();
        $repository->save($user);

        static::assertCount(1, $repository);

        $repository->remove($user);
        static::assertEmpty($repository);
    }

    public function testOfId(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);

        static::assertEmpty($repository);

        $user = DummyUserFactory::createUser();
        $repository->save($user);

        static::assertSame($user, $repository->ofId($user->id));
    }

    public function testWithPagination(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);
        static::assertNull($repository->paginator());

        $repository = $repository->withPagination(1, 2);

        static::assertInstanceOf(InMemoryPaginator::class, $repository->paginator());
    }

    public function testWithoutPagination(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);
        $repository = $repository->withPagination(1, 2);
        static::assertNotNull($repository->paginator());

        $repository = $repository->withoutPagination();
        static::assertNull($repository->paginator());
    }

    public function testIteratorWithoutPagination(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);
        static::assertNull($repository->paginator());

        $users = [
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
        ];
        foreach ($users as $user) {
            $repository->save($user);
        }

        $i = 0;
        foreach ($repository as $user) {
            static::assertSame($users[$i], $user);
            ++$i;
        }
    }

    public function testIteratorWithPagination(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);
        static::assertNull($repository->paginator());

        $users = [
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
        ];
        foreach ($users as $user) {
            $repository->save($user);
        }

        $repository = $repository->withPagination(1, 2);

        $i = 0;
        foreach ($repository as $user) {
            static::assertSame($users[$i], $user);
            ++$i;
        }

        static::assertSame(2, $i);

        $repository = $repository->withPagination(2, 2);

        $i = 0;
        foreach ($repository as $user) {
            static::assertSame($users[$i + 2], $user);
            ++$i;
        }

        static::assertSame(1, $i);
    }

    public function testCount(): void
    {
        /** @var InMemoryUserRepository $repository */
        $repository = static::getContainer()->get(InMemoryUserRepository::class);

        $users = [
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
            DummyUserFactory::createUser(),
        ];
        foreach ($users as $user) {
            $repository->save($user);
        }

        static::assertCount(count($users), $repository);
        static::assertCount(2, $repository->withPagination(1, 2));
    }
}
