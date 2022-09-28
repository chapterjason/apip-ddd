<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Domain\Exception;

use App\BookStore\Buyer\Domain\ValueObject\BuyerId;

final class MissingBuyerException extends \RuntimeException
{
    public function __construct(BuyerId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find buyer with id %s', (string) $id), $code, $previous);
    }
}
