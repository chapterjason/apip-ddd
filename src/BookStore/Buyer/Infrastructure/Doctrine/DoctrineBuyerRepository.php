<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Infrastructure\Doctrine;

use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends DoctrineRepository<Buyer>
 */
final class DoctrineBuyerRepository extends DoctrineRepository implements BuyerRepositoryInterface
{
    private const ENTITY_CLASS = Buyer::class;
    private const ALIAS = 'buyer';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Buyer $buyer): void
    {
        $this->em->persist($buyer);
        $this->em->flush();
    }

    public function remove(Buyer $buyer): void
    {
        $this->em->remove($buyer);
        $this->em->flush();
    }

    public function ofId(BuyerId $id): ?Buyer
    {
        return $this->em->find(self::ENTITY_CLASS, $id->value);
    }
}
