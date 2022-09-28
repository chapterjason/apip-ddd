<?php

declare(strict_types=1);

namespace App\BookStore\Book\Application\Command;

use App\BookStore\Book\Domain\ValueObject\BookId;
use App\BookStore\Book\Domain\ValueObject\Discount;
use App\Shared\Application\Command\CommandInterface;

final class DiscountBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
        public readonly Discount $discount,
    ) {
    }
}
