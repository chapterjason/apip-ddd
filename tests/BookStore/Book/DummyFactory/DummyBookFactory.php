<?php

declare(strict_types=1);

namespace App\Tests\BookStore\Book\DummyFactory;

use App\BookStore\Book\Domain\Model\Book;
use App\BookStore\Book\Domain\ValueObject\Author;
use App\BookStore\Book\Domain\ValueObject\BookContent;
use App\BookStore\Book\Domain\ValueObject\BookDescription;
use App\BookStore\Book\Domain\ValueObject\BookName;
use App\BookStore\Book\Domain\ValueObject\Price;

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
