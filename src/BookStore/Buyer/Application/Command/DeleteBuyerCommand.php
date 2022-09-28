<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Command;

use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteBuyerCommand implements CommandInterface
{
    public function __construct(
        public readonly BuyerId $id,
    ) {
    }
}
