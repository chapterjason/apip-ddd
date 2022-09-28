<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Query;

use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindBuyerQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function __invoke(FindBuyerQuery $query): ?Buyer
    {
        return $this->buyerRepository->ofId($query->id);
    }
}
