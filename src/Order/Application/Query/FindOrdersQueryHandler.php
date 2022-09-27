<?php

declare(strict_types=1);

namespace App\Order\Application\Query;

use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindOrdersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private OrderRepositoryInterface $bookOrderRepository)
    {
    }

    public function __invoke(FindOrdersQuery $query): OrderRepositoryInterface
    {
        $bookOrderRepository = $this->bookOrderRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $bookOrderRepository = $bookOrderRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $bookOrderRepository;
    }
}
