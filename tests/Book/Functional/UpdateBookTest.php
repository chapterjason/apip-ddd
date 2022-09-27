<?php

declare(strict_types=1);

namespace App\Tests\Book\Functional;

use App\Book\Application\Command\UpdateBookCommand;
use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Book\Domain\ValueObject\Author;
use App\Book\Domain\ValueObject\BookContent;
use App\Book\Domain\ValueObject\BookDescription;
use App\Book\Domain\ValueObject\BookName;
use App\Book\Domain\ValueObject\Price;
use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\Book\DummyFactory\DummyBookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UpdateBookTest extends KernelTestCase
{
    public function testUpdateBook(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        $initialBook = DummyBookFactory::createBook(
            name: 'name',
            description: 'description',
            author: 'author',
            content: 'content',
            price: 1000,
        );

        $bookRepository->save($initialBook);

        $commandBus->dispatch(new UpdateBookCommand(
            $initialBook->id,
            name: new BookName('newName'),
            content: new BookContent('newContent'),
            price: new Price(2000),
        ));

        $book = $bookRepository->ofId($initialBook->id);

        static::assertEquals(new BookName('newName'), $book->name);
        static::assertEquals(new BookDescription('description'), $book->description);
        static::assertEquals(new Author('author'), $book->author);
        static::assertEquals(new BookContent('newContent'), $book->content);
        static::assertEquals(new Price(2000), $book->price);
    }
}
