<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Query;

use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindBookOrderQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BookOrderRepositoryInterface $repository)
    {
    }

    public function __invoke(FindBookOrderQuery $query): ?BookOrder
    {
        return $this->repository->ofId($query->id);
    }
}
