<?php

declare(strict_types=1);

namespace App\Book\Application\Command;

use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Book\Domain\ValueObject\Author;
use App\Shared\Application\Command\CommandHandlerInterface;

final class AnonymizeBooksCommandHandler implements CommandHandlerInterface
{
    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function __invoke(AnonymizeBooksCommand $command): void
    {
        $books = $this->bookRepository->withoutPagination();

        foreach ($books as $book) {
            $book->author = new Author($command->anonymizedName);

            $this->bookRepository->save($book);
        }
    }
}
