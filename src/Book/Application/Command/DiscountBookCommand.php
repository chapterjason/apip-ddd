<?php

declare(strict_types=1);

namespace App\Book\Application\Command;

use App\Book\Domain\ValueObject\BookId;
use App\Book\Domain\ValueObject\Discount;
use App\Shared\Application\Command\CommandInterface;

final class DiscountBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
        public readonly Discount $discount,
    ) {
    }
}
