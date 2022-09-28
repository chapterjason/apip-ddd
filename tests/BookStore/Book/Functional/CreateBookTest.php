<?php

declare(strict_types=1);

namespace App\Tests\BookStore\Book\Functional;

use App\BookStore\Book\Application\Command\CreateBookCommand;
use App\BookStore\Book\Domain\Repository\BookRepositoryInterface;
use App\BookStore\Book\Domain\ValueObject\Author;
use App\BookStore\Book\Domain\ValueObject\BookContent;
use App\BookStore\Book\Domain\ValueObject\BookDescription;
use App\BookStore\Book\Domain\ValueObject\BookName;
use App\BookStore\Book\Domain\ValueObject\Price;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CreateBookTest extends KernelTestCase
{
    public function testCreateBook(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        static::assertEmpty($bookRepository);

        $commandBus->dispatch(new CreateBookCommand(
            new BookName('name'),
            new BookDescription('description'),
            new Author('author'),
            new BookContent('content'),
            new Price(1000),
        ));

        static::assertCount(1, $bookRepository);

        $book = array_values(iterator_to_array($bookRepository))[0];

        static::assertEquals(new BookName('name'), $book->name);
        static::assertEquals(new BookDescription('description'), $book->description);
        static::assertEquals(new Author('author'), $book->author);
        static::assertEquals(new BookContent('content'), $book->content);
        static::assertEquals(new Price(1000), $book->price);
    }
}
