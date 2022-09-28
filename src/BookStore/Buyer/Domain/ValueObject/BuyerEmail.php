<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Email;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class BuyerEmail extends Email
{
}
