<?php

declare(strict_types=1);

namespace App\Identity\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Email;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class UserEmail extends Email
{
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    public readonly string $value;
}
