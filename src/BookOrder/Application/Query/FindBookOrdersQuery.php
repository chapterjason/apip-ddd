<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final class FindBookOrdersQuery implements QueryInterface
{
    public function __construct(
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
