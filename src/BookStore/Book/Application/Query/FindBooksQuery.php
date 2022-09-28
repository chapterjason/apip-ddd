<?php

declare(strict_types=1);

namespace App\BookStore\Book\Application\Query;

use App\BookStore\Book\Domain\ValueObject\Author;
use App\Shared\Application\Query\QueryInterface;

final class FindBooksQuery implements QueryInterface
{
    public function __construct(
        public readonly ?Author $author = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
