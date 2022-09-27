<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\UserId;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserId $id,
    ) {
    }
}
