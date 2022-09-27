<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
abstract class Email implements \Stringable
{
    #[ORM\Column(type: 'string', length: 255)]
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
