<?php

declare(strict_types=1);

namespace App\BookStore\Order\Application\Command;

use App\BookStore\Book\Application\Query\FindBookQuery;
use App\BookStore\Book\Domain\Exception\MissingBookException;
use App\BookStore\Book\Domain\Model\Book;
use App\BookStore\Buyer\Application\Query\FindBuyerQuery;
use App\BookStore\Buyer\Domain\Exception\MissingBuyerException;
use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Query\QueryBusInterface;

final class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $bookOrderRepository,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(CreateOrderCommand $command): Order
    {
        /**
         * @var Book|null $book
         */
        $book = $this->queryBus->ask(new FindBookQuery($command->bookId));

        if (null === $book) {
            throw new MissingBookException($command->bookId);
        }

        /**
         * @var Buyer|null $buyer
         */
        $buyer = $this->queryBus->ask(new FindBuyerQuery($command->buyerId));

        if (null === $buyer) {
            throw new MissingBuyerException($command->buyerId);
        }

        $bookOrder = new Order(
            $book,
            $buyer,
        );

        $this->bookOrderRepository->save($bookOrder);

        return $bookOrder;
    }
}
