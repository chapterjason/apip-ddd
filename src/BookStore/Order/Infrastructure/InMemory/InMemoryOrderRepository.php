<?php

declare(strict_types=1);

namespace App\BookStore\Order\Infrastructure\InMemory;

use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Domain\Repository\OrderRepositoryInterface;
use App\BookStore\Order\Domain\ValueObject\OrderId;
use App\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<Order>
 */
final class InMemoryOrderRepository extends InMemoryRepository implements OrderRepositoryInterface
{
    public function save(Order $order): void
    {
        $this->entities[(string) $order->id] = $order;
    }

    public function remove(Order $order): void
    {
        unset($this->entities[(string) $order->id]);
    }

    public function ofId(OrderId $id): ?Order
    {
        return $this->entities[(string) $id] ?? null;
    }
}
