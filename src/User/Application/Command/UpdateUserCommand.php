<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Domain\ValueObject\UserId;

final class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserId $id,
        public readonly ?UserEmail $email = null,
    ) {
    }
}
