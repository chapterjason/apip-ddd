<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Query;

use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\Shared\Application\Query\QueryInterface;

final class FindBookOrderQuery implements QueryInterface
{
    public function __construct(
        public readonly BookOrderId $id,
    ) {
    }
}
