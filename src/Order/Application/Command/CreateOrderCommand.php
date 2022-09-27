<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Book\Domain\ValueObject\BookId;
use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\UserId;

final class CreateOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $bookId,
        public readonly UserId $buyerId,
    ) {
    }
}
