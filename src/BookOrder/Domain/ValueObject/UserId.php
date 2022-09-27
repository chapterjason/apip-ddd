<?php

declare(strict_types=1);

namespace App\BookOrder\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid;

#[ORM\Embeddable]
final class UserId
{
    #[ORM\Column(name: 'user_id', type: 'uuid')]
    public readonly AbstractUid $value;

    public function __construct(AbstractUid $value)
    {
        $this->value = $value;
    }
}
