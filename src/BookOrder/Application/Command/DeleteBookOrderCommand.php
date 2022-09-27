<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Command;

use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteBookOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly BookOrderId $id,
    ) {
    }
}
