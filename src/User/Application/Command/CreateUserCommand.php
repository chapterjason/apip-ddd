<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\UserEmail;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UserEmail $email,
    ) {
    }
}
