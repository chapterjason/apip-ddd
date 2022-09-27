<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Book\Domain\ValueObject\BookId;
use App\Order\Domain\ValueObject\OrderId;
use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\UserId;

final class UpdateOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly OrderId $id,
        public readonly ?BookId $bookId = null,
        public readonly ?UserId $buyerId = null,
    ) {
    }
}
