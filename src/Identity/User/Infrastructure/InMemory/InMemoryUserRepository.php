<?php

declare(strict_types=1);

namespace App\Identity\User\Infrastructure\InMemory;

use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<User>
 */
final class InMemoryUserRepository extends InMemoryRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $this->entities[(string) $user->id] = $user;
    }

    public function remove(User $user): void
    {
        unset($this->entities[(string) $user->id]);
    }

    public function ofId(UserId $id): ?User
    {
        return $this->entities[(string) $id] ?? null;
    }

    public function exists(UserId $id): bool
    {
        return isset($this->entities[(string) $id]);
    }
}
