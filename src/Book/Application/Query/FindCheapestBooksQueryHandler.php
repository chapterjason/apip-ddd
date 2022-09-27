<?php

declare(strict_types=1);

namespace App\Book\Application\Query;

use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindCheapestBooksQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function __invoke(FindCheapestBooksQuery $query): BookRepositoryInterface
    {
        return $this->bookRepository
            ->withCheapestsFirst()
            ->withPagination(1, $query->size);
    }
}
