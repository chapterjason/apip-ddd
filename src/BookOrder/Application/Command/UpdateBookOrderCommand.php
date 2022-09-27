<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Command;

use App\BookOrder\Domain\ValueObject\BookId;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\BookOrder\Domain\ValueObject\UserId;
use App\Shared\Application\Command\CommandInterface;

final class UpdateBookOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly BookOrderId $id,
        public readonly ?BookId $bookId = null,
        public readonly ?UserId $userId = null,
    ) {
    }
}
