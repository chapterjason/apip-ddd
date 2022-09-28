<?php

declare(strict_types=1);

namespace App\IdentityIntegration\Application\Event;

use App\Shared\Application\Event\EventInterface;
use App\Shared\Domain\ValueObject\AggregateRootId;
use App\Shared\Domain\ValueObject\Email;

final class UserCreatedEvent implements EventInterface
{
    public function __construct(
        public readonly AggregateRootId $id,
        public readonly Email $email,
    ) {
    }
}
