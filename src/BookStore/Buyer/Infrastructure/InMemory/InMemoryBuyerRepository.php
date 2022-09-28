<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Infrastructure\InMemory;

use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<Buyer>
 */
final class InMemoryBuyerRepository extends InMemoryRepository implements BuyerRepositoryInterface
{
    public function save(Buyer $buyer): void
    {
        $this->entities[(string) $buyer->id] = $buyer;
    }

    public function remove(Buyer $buyer): void
    {
        unset($this->entities[(string) $buyer->id]);
    }

    public function ofId(BuyerId $id): ?Buyer
    {
        return $this->entities[(string) $id] ?? null;
    }
}
