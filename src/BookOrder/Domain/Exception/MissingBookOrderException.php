<?php

declare(strict_types=1);

namespace App\BookOrder\Domain\Exception;

use App\BookOrder\Domain\ValueObject\BookOrderId;

final class MissingBookOrderException extends \RuntimeException
{
    public function __construct(BookOrderId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find bookOrder with id %s', (string) $id), $code, $previous);
    }
}
