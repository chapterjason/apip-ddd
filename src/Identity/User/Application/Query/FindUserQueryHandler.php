<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Query;

use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function __invoke(FindUserQuery $query): ?User
    {
        return $this->repository->ofId($query->id);
    }
}
