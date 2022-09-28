<?php

declare(strict_types=1);

namespace App\BookStore\Book\Application\Command;

use App\BookStore\Book\Domain\ValueObject\BookId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
    ) {
    }
}
