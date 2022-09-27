<?php

declare(strict_types=1);

namespace App\Order\Application\Query;

use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindOrderQueryHandler implements QueryHandlerInterface
{
    public function __construct(private OrderRepositoryInterface $repository)
    {
    }

    public function __invoke(FindOrderQuery $query): ?Order
    {
        return $this->repository->ofId($query->id);
    }
}
