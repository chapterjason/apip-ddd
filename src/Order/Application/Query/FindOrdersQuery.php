<?php

declare(strict_types=1);

namespace App\Order\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final class FindOrdersQuery implements QueryInterface
{
    public function __construct(
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
