<?php

declare(strict_types=1);

namespace App\Order\Domain\Model;

use App\Book\Domain\Model\Book;
use App\Order\Domain\ValueObject\OrderId;
use App\User\Domain\Model\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Order
{
    #[ORM\Embedded(columnPrefix: false)]
    public OrderId $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Book::class)]
        #[ORM\JoinColumn(name: 'book_id', referencedColumnName: 'id')]
        public Book $book,

        #[ORM\ManyToOne(targetEntity: User::class)]
        #[ORM\JoinColumn(name: 'buyer_id', referencedColumnName: 'id')]
        public User $buyer,
    ) {
        $this->id = new OrderId();
    }
}
