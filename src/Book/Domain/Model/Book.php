<?php

declare(strict_types=1);

namespace App\Book\Domain\Model;

use App\Book\Domain\ValueObject\Author;
use App\Book\Domain\ValueObject\BookContent;
use App\Book\Domain\ValueObject\BookDescription;
use App\Book\Domain\ValueObject\BookId;
use App\Book\Domain\ValueObject\BookName;
use App\Book\Domain\ValueObject\Discount;
use App\Book\Domain\ValueObject\Price;
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
