<?php

declare(strict_types=1);

namespace App\BookOrder\Domain\Repository;

use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<BookOrder>
 */
interface BookOrderRepositoryInterface extends RepositoryInterface
{
    public function save(BookOrder $bookOrder): void;

    public function remove(BookOrder $bookOrder): void;

    public function ofId(BookOrderId $id): ?BookOrder;
}
