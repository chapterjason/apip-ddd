<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Domain\Model;

use App\BookStore\Buyer\Domain\ValueObject\BuyerEmail;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Buyer
{
    #[ORM\Embedded(columnPrefix: false)]
    public readonly BuyerId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        public BuyerEmail $email,

        ?BuyerId $id = null,
    ) {
        $this->id = $id ?? new BuyerId();
    }
}
