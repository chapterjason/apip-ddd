<?php

declare(strict_types=1);

namespace App\BookStore\Book\Domain\Repository;

use App\BookStore\Book\Domain\Model\Book;
use App\BookStore\Book\Domain\ValueObject\Author;
use App\BookStore\Book\Domain\ValueObject\BookId;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Book>
 */
interface BookRepositoryInterface extends RepositoryInterface
{
    public function save(Book $book): void;

    public function remove(Book $book): void;

    public function ofId(BookId $id): ?Book;

    public function withAuthor(Author $author): static;

    public function withCheapestsFirst(): static;
}
