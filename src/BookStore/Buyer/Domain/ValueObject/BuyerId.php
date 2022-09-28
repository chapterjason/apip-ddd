<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class BuyerId extends AggregateRootId
{
}
