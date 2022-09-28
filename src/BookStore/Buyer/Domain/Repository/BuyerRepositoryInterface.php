<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Domain\Repository;

use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Buyer>
 */
interface BuyerRepositoryInterface extends RepositoryInterface
{
    public function save(Buyer $buyer): void;

    public function remove(Buyer $buyer): void;

    public function ofId(BuyerId $id): ?Buyer;
}
