<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Command;

use App\BookStore\Buyer\Domain\ValueObject\BuyerEmail;
use App\Shared\Application\Command\CommandInterface;

final class CreateBuyerCommand implements CommandInterface
{
    public function __construct(
        public readonly BuyerEmail $email,
    ) {
    }
}
