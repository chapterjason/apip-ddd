<?php

declare(strict_types=1);

namespace App\BookOrder\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid;

#[ORM\Embeddable]
final class BookId extends AggregateRootId
{
}
