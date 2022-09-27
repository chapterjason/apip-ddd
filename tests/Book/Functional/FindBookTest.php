<?php

declare(strict_types=1);

namespace App\Tests\Book\Functional;

use App\Book\Application\Query\FindBookQuery;
use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Book\DummyFactory\DummyBookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FindBookTest extends KernelTestCase
{
    public function testFindBook(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $book = DummyBookFactory::createBook();
        $bookRepository->save($book);

        static::assertSame($book, $queryBus->ask(new FindBookQuery($book->id)));
    }
}
