<?php

declare(strict_types=1);

namespace App\Tests\Book\Functional;

use App\Book\Application\Query\FindBooksQuery;
use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Book\Domain\ValueObject\Author;
use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Book\DummyFactory\DummyBookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FindBooksTest extends KernelTestCase
{
    public function testFindBooks(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $initialBooks = [
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
        ];

        foreach ($initialBooks as $book) {
            $bookRepository->save($book);
        }

        $books = $queryBus->ask(new FindBooksQuery());

        static::assertCount(count($initialBooks), $books);
        foreach ($books as $book) {
            static::assertContains($book, $initialBooks);
        }
    }

    public function testFilterBooksByAuthor(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $bookRepository->save(DummyBookFactory::createBook(author: 'authorOne'));
        $bookRepository->save(DummyBookFactory::createBook(author: 'authorOne'));
        $bookRepository->save(DummyBookFactory::createBook(author: 'authorTwo'));

        static::assertCount(3, $bookRepository);

        $books = $queryBus->ask(new FindBooksQuery(author: new Author('authorOne')));

        static::assertCount(2, $books);
        foreach ($books as $book) {
            static::assertEquals(new Author('authorOne'), $book->author);
        }
    }

    public function testReturnPaginatedBooks(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $initialBooks = [
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
        ];

        foreach ($initialBooks as $book) {
            $bookRepository->save($book);
        }

        $books = $queryBus->ask(new FindBooksQuery(page: 2, itemsPerPage: 2));

        static::assertCount(2, $books);
        $i = 0;
        foreach ($books as $book) {
            static::assertSame($initialBooks[$i + 2], $book);
            ++$i;
        }
    }
}
