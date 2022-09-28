<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Query;

use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\Shared\Application\Query\QueryInterface;

final class FindBuyerQuery implements QueryInterface
{
    public function __construct(
        public readonly BuyerId $id,
    ) {
    }
}
