<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class UserEmail implements \Stringable
{
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::email($value);

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
