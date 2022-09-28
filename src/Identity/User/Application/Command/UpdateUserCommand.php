<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Command;

use App\Identity\User\Domain\ValueObject\UserEmail;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Shared\Application\Command\CommandInterface;

final class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserId $id,
        public readonly ?UserEmail $email = null,
    ) {
    }
}
