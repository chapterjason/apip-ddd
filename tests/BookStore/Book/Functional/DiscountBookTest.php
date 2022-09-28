<?php

declare(strict_types=1);

namespace App\Tests\BookStore\Book\Functional;

use App\BookStore\Book\Application\Command\DiscountBookCommand;
use App\BookStore\Book\Domain\Repository\BookRepositoryInterface;
use App\BookStore\Book\Domain\ValueObject\Discount;
use App\BookStore\Book\Domain\ValueObject\Price;
use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\BookStore\Book\DummyFactory\DummyBookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DiscountBookTest extends KernelTestCase
{
    /**
     * @dataProvider applyADiscountOnBookDataProvider
     */
    public function testApplyADiscountOnBook(int $initialAmount, int $discount, int $expectedAmount): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        $book = DummyBookFactory::createBook(price: $initialAmount);
        $bookRepository->save($book);

        $commandBus->dispatch(new DiscountBookCommand($book->id, new Discount($discount)));

        static::assertEquals(new Price($expectedAmount), $bookRepository->ofId($book->id)->price);
    }

    public function applyADiscountOnBookDataProvider(): iterable
    {
        yield [100, 0, 100];
        yield [100, 20, 80];
        yield [50, 30, 35];
        yield [50, 100, 0];
    }
}
