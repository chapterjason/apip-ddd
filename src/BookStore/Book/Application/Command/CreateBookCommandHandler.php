<?php

declare(strict_types=1);

namespace App\BookStore\Book\Application\Command;

use App\BookStore\Book\Domain\Model\Book;
use App\BookStore\Book\Domain\Repository\BookRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class CreateBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookRepositoryInterface $bookRepository)
    {
    }

    public function __invoke(CreateBookCommand $command): Book
    {
        $book = new Book(
            $command->name,
            $command->description,
            $command->author,
            $command->content,
            $command->price,
        );

        $this->bookRepository->save($book);

        return $book;
    }
}
