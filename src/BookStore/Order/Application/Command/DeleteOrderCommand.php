<?php

declare(strict_types=1);

namespace App\BookStore\Order\Application\Command;

use App\BookStore\Order\Domain\ValueObject\OrderId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly OrderId $id,
    ) {
    }
}
