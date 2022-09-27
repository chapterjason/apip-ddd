<?php

declare(strict_types=1);

namespace App\Tests\Book\DummyFactory;

use App\Book\Domain\Model\Book;
use App\Book\Domain\ValueObject\Author;
use App\Book\Domain\ValueObject\BookContent;
use App\Book\Domain\ValueObject\BookDescription;
use App\Book\Domain\ValueObject\BookName;
use App\Book\Domain\ValueObject\Price;

final class DummyBookFactory
{
    private function __construct()
    {
    }

    public static function createBook(
        string $name = 'name',
        string $description = 'description',
        string $author = 'author',
        string $content = 'content',
        int $price = 1000,
    ): Book {
        return new Book(
            new BookName($name),
            new BookDescription($description),
            new Author($author),
            new BookContent($content),
            new Price($price),
        );
    }
}
