<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Command;

use App\Identity\User\Domain\ValueObject\UserId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserId $id,
    ) {
    }
}
