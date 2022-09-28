<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Query;

use App\Identity\User\Domain\ValueObject\UserId;
use App\Shared\Application\Query\QueryInterface;

final class FindUserQuery implements QueryInterface
{
    public function __construct(
        public readonly UserId $id,
    ) {
    }
}
