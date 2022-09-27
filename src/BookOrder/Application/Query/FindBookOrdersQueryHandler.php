<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Query;

use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindBookOrdersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BookOrderRepositoryInterface $bookOrderRepository)
    {
    }

    public function __invoke(FindBookOrdersQuery $query): BookOrderRepositoryInterface
    {
        $bookOrderRepository = $this->bookOrderRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $bookOrderRepository = $bookOrderRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $bookOrderRepository;
    }
}
