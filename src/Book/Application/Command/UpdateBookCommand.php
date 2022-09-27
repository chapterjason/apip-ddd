<?php

declare(strict_types=1);

namespace App\Book\Application\Command;

use App\Book\Domain\ValueObject\Author;
use App\Book\Domain\ValueObject\BookContent;
use App\Book\Domain\ValueObject\BookDescription;
use App\Book\Domain\ValueObject\BookId;
use App\Book\Domain\ValueObject\BookName;
use App\Book\Domain\ValueObject\Price;
use App\Shared\Application\Command\CommandInterface;

final class UpdateBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
        public readonly ?BookName $name = null,
        public readonly ?BookDescription $description = null,
        public readonly ?Author $author = null,
        public readonly ?BookContent $content = null,
        public readonly ?Price $price = null,
    ) {
    }
}
