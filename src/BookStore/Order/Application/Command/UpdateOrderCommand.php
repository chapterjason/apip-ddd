<?php

declare(strict_types=1);

namespace App\BookStore\Order\Application\Command;

use App\BookStore\Book\Domain\ValueObject\BookId;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\BookStore\Order\Domain\ValueObject\OrderId;
use App\Shared\Application\Command\CommandInterface;

final class UpdateOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly OrderId $id,
        public readonly ?BookId $bookId = null,
        public readonly ?BuyerId $buyerId = null,
    ) {
    }
}
