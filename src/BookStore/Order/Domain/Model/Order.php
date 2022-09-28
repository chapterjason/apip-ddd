<?php

declare(strict_types=1);

namespace App\BookStore\Order\Domain\Model;

use App\BookStore\Book\Domain\Model\Book;
use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Order\Domain\ValueObject\OrderId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '"order"')]
class Order
{
    #[ORM\Embedded(columnPrefix: false)]
    public OrderId $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Book::class)]
        #[ORM\JoinColumn(name: 'book_id', referencedColumnName: 'id')]
        public Book $book,

        #[ORM\ManyToOne(targetEntity: Buyer::class)]
        #[ORM\JoinColumn(name: 'buyer_id', referencedColumnName: 'id')]
        public Buyer $buyer,
    ) {
        $this->id = new OrderId();
    }
}
