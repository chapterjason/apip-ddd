<?php

declare(strict_types=1);

namespace App\BookStore\Book\Domain\Model;

use App\BookStore\Book\Domain\ValueObject\Author;
use App\BookStore\Book\Domain\ValueObject\BookContent;
use App\BookStore\Book\Domain\ValueObject\BookDescription;
use App\BookStore\Book\Domain\ValueObject\BookId;
use App\BookStore\Book\Domain\ValueObject\BookName;
use App\BookStore\Book\Domain\ValueObject\Discount;
use App\BookStore\Book\Domain\ValueObject\Price;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Book
{
    #[ORM\Embedded(columnPrefix: false)]
    public readonly BookId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        public BookName $name,

        #[ORM\Embedded(columnPrefix: false)]
        public BookDescription $description,

        #[ORM\Embedded(columnPrefix: false)]
        public Author $author,

        #[ORM\Embedded(columnPrefix: false)]
        public BookContent $content,

        #[ORM\Embedded(columnPrefix: false)]
        public Price $price,
    ) {
        $this->id = new BookId();
    }

    public function applyDiscount(Discount $discount): static
    {
        $this->price = $this->price->applyDiscount($discount);

        return $this;
    }
}
