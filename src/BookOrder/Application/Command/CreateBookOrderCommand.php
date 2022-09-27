<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Command;

use App\BookOrder\Domain\ValueObject\BookId;
use App\BookOrder\Domain\ValueObject\UserId;
use App\Shared\Application\Command\CommandInterface;

final class CreateBookOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $bookId,
        public readonly UserId $userId,
    ) {
    }
}
