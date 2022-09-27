<?php

declare(strict_types=1);

namespace App\Book\Application\Command;

use App\Book\Domain\Exception\MissingBookException;
use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class DiscountBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookRepositoryInterface $bookRepository)
    {
    }

    public function __invoke(DiscountBookCommand $command): void
    {
        $book = $this->bookRepository->ofId($command->id);
        if (null === $book) {
            throw new MissingBookException($command->id);
        }

        $book->applyDiscount($command->discount);

        $this->bookRepository->save($book);
    }
}
