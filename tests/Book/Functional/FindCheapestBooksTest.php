<?php

declare(strict_types=1);

namespace App\Tests\Book\Functional;

use App\Book\Application\Query\FindCheapestBooksQuery;
use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Book\Domain\ValueObject\Price;
use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Book\DummyFactory\DummyBookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FindCheapestBooksTest extends KernelTestCase
{
    public function testReturnOnlyTheCheapestBooks(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        for ($i = 0; $i < 5; ++$i) {
            $bookRepository->save(DummyBookFactory::createBook());
        }

        $cheapestBooks = $queryBus->ask(new FindCheapestBooksQuery(3));

        static::assertCount(3, $cheapestBooks);
    }

    public function testReturnBooksSortedByPrice(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var QueryBusInterface $queryBus */
        $queryBus = static::getContainer()->get(QueryBusInterface::class);

        $prices = [2000, 1000, 3000];
        foreach ($prices as $price) {
            $bookRepository->save(DummyBookFactory::createBook(price: $price));
        }

        $cheapestBooks = $queryBus->ask(new FindCheapestBooksQuery(3));

        $sortedPrices = [1000, 2000, 3000];

        $i = 0;
        foreach ($cheapestBooks as $book) {
            static::assertEquals(new Price($sortedPrices[$i]), $book->price);
            ++$i;
        }
    }
}
