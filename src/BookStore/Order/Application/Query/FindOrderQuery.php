<?php

declare(strict_types=1);

namespace App\BookStore\Order\Application\Query;

use App\BookStore\Order\Domain\ValueObject\OrderId;
use App\Shared\Application\Query\QueryInterface;

final class FindOrderQuery implements QueryInterface
{
    public function __construct(
        public readonly OrderId $id,
    ) {
    }
}
