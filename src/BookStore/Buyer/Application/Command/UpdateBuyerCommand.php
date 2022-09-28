<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Command;

use App\BookStore\Buyer\Domain\ValueObject\BuyerEmail;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\Shared\Application\Command\CommandInterface;

final class UpdateBuyerCommand implements CommandInterface
{
    public function __construct(
        public readonly BuyerId $id,
        public readonly ?BuyerEmail $email = null,
    ) {
    }
}
