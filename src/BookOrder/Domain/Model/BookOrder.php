<?php

declare(strict_types=1);

namespace App\BookOrder\Domain\Model;

use App\BookOrder\Domain\ValueObject\BookId;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\BookOrder\Domain\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class BookOrder
{
    #[ORM\Embedded(columnPrefix: false)]
    public BookOrderId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        public BookId $bookId,

        #[ORM\Embedded(columnPrefix: false)]
        public UserId $userId,
    ) {
        $this->id = new BookOrderId();
    }
}
