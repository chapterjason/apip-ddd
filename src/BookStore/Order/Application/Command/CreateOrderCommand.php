<?php

declare(strict_types=1);

namespace App\BookStore\Order\Application\Command;

use App\BookStore\Book\Domain\ValueObject\BookId;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\Shared\Application\Command\CommandInterface;

final class CreateOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $bookId,
        public readonly BuyerId $buyerId,
    ) {
    }
}
