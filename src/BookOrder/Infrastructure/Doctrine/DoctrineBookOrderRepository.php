<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\Doctrine;

use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends DoctrineRepository<BookOrder>
 */
final class DoctrineBookOrderRepository extends DoctrineRepository implements BookOrderRepositoryInterface
{
    private const ENTITY_CLASS = BookOrder::class;
    private const ALIAS = 'bookOrder';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(BookOrder $bookOrder): void
    {
        $this->em->persist($bookOrder);
        $this->em->flush();
    }

    public function remove(BookOrder $bookOrder): void
    {
        $this->em->remove($bookOrder);
        $this->em->flush();
    }

    public function ofId(BookOrderId $id): ?BookOrder
    {
        return $this->em->find(self::ENTITY_CLASS, $id->value);
    }
}
