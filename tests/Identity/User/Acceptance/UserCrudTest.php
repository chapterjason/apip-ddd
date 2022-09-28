<?php

declare(strict_types=1);

namespace App\Tests\Identity\User\Acceptance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Identity\User\Domain\ValueObject\UserEmail;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Identity\User\Infrastructure\ApiPlatform\Resource\UserResource;
use App\Tests\Identity\User\DummyFactory\DummyUserFactory;
use Symfony\Component\Uid\Uuid;

final class UserCrudTest extends ApiTestCase
{
    public function testReturnPaginatedUsers(): void
    {
        $client = static::createClient();

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        for ($i = 0; $i < 100; ++$i) {
            $userRepository->save(DummyUserFactory::createUser());
        }

        $client->request('GET', '/api/users');

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceCollectionJsonSchema(UserResource::class);

        static::assertJsonContains([
            'hydra:totalItems' => 100,
            'hydra:view' => [
                'hydra:first' => '/api/users?page=1',
                'hydra:next' => '/api/users?page=2',
                'hydra:last' => '/api/users?page=4',
            ],
        ]);
    }

    public function testReturnUser(): void
    {
        $client = static::createClient();

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        $user = DummyUserFactory::createUser();
        $userRepository->save($user);

        $client->request('GET', sprintf('/api/users/%s', (string) $user->id));

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceItemJsonSchema(UserResource::class);

        static::assertJsonContains([
            'email' => $user->email->value,
        ]);
    }

    public function testCreateUser(): void
    {
        $client = static::createClient();

        $response = $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'test@test.com',
            ],
        ]);

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceItemJsonSchema(UserResource::class);

        static::assertJsonContains([
            'email' => 'test@test.com',
        ]);

        $id = new UserId(Uuid::fromString(str_replace('/api/users/', '', $response->toArray()['@id'])));

        $user = static::getContainer()->get(UserRepositoryInterface::class)->ofId($id);

        static::assertNotNull($user);
        static::assertEquals($id, $user->id);
        static::assertEquals(new UserEmail('test@test.com'), $user->email);
    }

    public function testCannotCreateUserWithoutValidPayload(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => '',
            ],
        ]);

        static::assertResponseIsUnprocessable();
        static::assertJsonContains([
            'violations' => [
                ['propertyPath' => 'email', 'message' => 'This value is too short. It should have 1 character or more.'],
            ],
        ]);

        $client->request('POST', '/api/users', [
            'json' => [],
        ]);

        static::assertResponseIsUnprocessable();
        static::assertJsonContains([
            'violations' => [
                ['propertyPath' => 'email', 'message' => 'This value should not be null.'],
            ],
        ]);
    }

    public function testUpdateUser(): void
    {
        $client = static::createClient();

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        $user = DummyUserFactory::createUser();
        $userRepository->save($user);

        $client->request('PUT', sprintf('/api/users/%s', (string) $user->id), [
            'json' => [
                'email' => 'foo@test.com',
            ],
        ]);

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceItemJsonSchema(UserResource::class);

        static::assertJsonContains([
            'email' => 'foo@test.com',
        ]);

        $updatedUser = $userRepository->ofId($user->id);

        static::assertNotNull($user);
        static::assertEquals(new UserEmail('foo@test.com'), $updatedUser->email);
    }

    public function testPartiallyUpdateUser(): void
    {
        $client = static::createClient();

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        $user = DummyUserFactory::createUser();
        $userRepository->save($user);

        $client->request('PATCH', sprintf('/api/users/%s', (string) $user->id), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'email' => 'foo@test.com',
            ],
        ]);

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceItemJsonSchema(UserResource::class);

        static::assertJsonContains([
            'email' => 'foo@test.com',
        ]);

        $updatedUser = $userRepository->ofId($user->id);

        static::assertNotNull($user);
        static::assertEquals(new UserEmail('foo@test.com'), $updatedUser->email);
    }

    public function testDeleteUser(): void
    {
        $client = static::createClient();

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        $user = DummyUserFactory::createUser();
        $userRepository->save($user);

        $response = $client->request('DELETE', sprintf('/api/users/%s', (string) $user->id));

        static::assertResponseIsSuccessful();
        static::assertEmpty($response->getContent());

        static::assertNull($userRepository->ofId($user->id));
    }
}
