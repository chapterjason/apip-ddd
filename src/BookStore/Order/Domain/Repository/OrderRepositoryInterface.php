<?php

declare(strict_types=1);

namespace App\BookStore\Order\Domain\Repository;

use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Domain\ValueObject\OrderId;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Order>
 */
interface OrderRepositoryInterface extends RepositoryInterface
{
    public function save(Order $order): void;

    public function remove(Order $order): void;

    public function ofId(OrderId $id): ?Order;
}
