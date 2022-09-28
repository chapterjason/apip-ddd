<?php

declare(strict_types=1);

namespace App\BookStore\Order\Domain\Exception;

use App\BookStore\Order\Domain\ValueObject\OrderId;

final class MissingOrderException extends \RuntimeException
{
    public function __construct(OrderId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find bookOrder with id %s', (string) $id), $code, $previous);
    }
}
