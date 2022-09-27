<?php

declare(strict_types=1);

namespace App\Book\Application\Command;

use App\Book\Domain\ValueObject\BookId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
    ) {
    }
}
