<?php

declare(strict_types=1);

namespace App\Identity\User\Domain\Repository;

use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function ofId(UserId $id): ?User;

    public function exists(UserId $id): bool;
}
