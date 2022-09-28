<?php

declare(strict_types=1);

namespace App\Identity\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class UserId extends AggregateRootId
{
}
