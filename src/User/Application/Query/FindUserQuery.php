<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use App\User\Domain\ValueObject\UserId;

final class FindUserQuery implements QueryInterface
{
    public function __construct(
        public readonly UserId $id,
    ) {
    }
}
