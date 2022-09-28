<?php

declare(strict_types=1);

namespace App\Identity\User\Application\Command;

use App\Identity\User\Domain\ValueObject\UserEmail;
use App\Shared\Application\Command\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserEmail $email,
    ) {
    }
}
