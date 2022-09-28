<?php

declare(strict_types=1);

namespace App\Tests\BookStore\Book\Functional;

use App\BookStore\Book\Application\Command\DeleteBookCommand;
use App\BookStore\Book\Domain\Repository\BookRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\BookStore\Book\DummyFactory\DummyBookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DeleteBookTest extends KernelTestCase
{
    public function testDeleteBook(): void
    {
        /** @var BookRepositoryInterface $bookRepository */
        $bookRepository = static::getContainer()->get(BookRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        $book = DummyBookFactory::createBook();
        $bookRepository->save($book);

        static::assertCount(1, $bookRepository);

        $commandBus->dispatch(new DeleteBookCommand($book->id));

        static::assertEmpty($bookRepository);
    }
}
