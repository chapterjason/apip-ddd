<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\InMemory;

use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<BookOrder>
 */
final class InMemoryBookOrderRepository extends InMemoryRepository implements BookOrderRepositoryInterface
{
    public function save(BookOrder $bookOrder): void
    {
        $this->entities[(string) $bookOrder->id] = $bookOrder;
    }

    public function remove(BookOrder $bookOrder): void
    {
        unset($this->entities[(string) $bookOrder->id]);
    }

    public function ofId(BookOrderId $id): ?BookOrder
    {
        return $this->entities[(string) $id] ?? null;
    }
}
