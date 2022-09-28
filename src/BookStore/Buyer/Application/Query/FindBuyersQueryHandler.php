<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Query;

use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindBuyersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function __invoke(FindBuyersQuery $query): BuyerRepositoryInterface
    {
        $buyerRepository = $this->buyerRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $buyerRepository = $buyerRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $buyerRepository;
    }
}
