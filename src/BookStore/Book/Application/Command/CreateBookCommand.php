<?php

declare(strict_types=1);

namespace App\BookStore\Book\Application\Command;

use App\BookStore\Book\Domain\ValueObject\Author;
use App\BookStore\Book\Domain\ValueObject\BookContent;
use App\BookStore\Book\Domain\ValueObject\BookDescription;
use App\BookStore\Book\Domain\ValueObject\BookName;
use App\BookStore\Book\Domain\ValueObject\Price;
use App\Shared\Application\Command\CommandInterface;

final class CreateBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookName $name,
        public readonly BookDescription $description,
        public readonly Author $author,
        public readonly BookContent $content,
        public readonly Price $price,
    ) {
    }
}
