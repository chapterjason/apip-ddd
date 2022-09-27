<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Doctrine;

use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Order\Domain\ValueObject\OrderId;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends DoctrineRepository<Order>
 */
final class DoctrineOrderRepository extends DoctrineRepository implements OrderRepositoryInterface
{
    private const ENTITY_CLASS = Order::class;
    private const ALIAS = 'order';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Order $order): void
    {
        $this->em->persist($order);
        $this->em->flush();
    }

    public function remove(Order $order): void
    {
        $this->em->remove($order);
        $this->em->flush();
    }

    public function ofId(OrderId $id): ?Order
    {
        return $this->em->find(self::ENTITY_CLASS, $id->value);
    }
}
