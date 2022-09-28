<?php

declare(strict_types=1);

namespace App\BookStore\Order\Application\Command;

use App\BookStore\Book\Application\Query\FindBookQuery;
use App\BookStore\Book\Domain\Exception\MissingBookException;
use App\BookStore\Book\Domain\Model\Book;
use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Domain\Repository\OrderRepositoryInterface;
use App\Identity\User\Application\Query\FindUserQuery;
use App\Identity\User\Domain\Exception\MissingUserException;
use App\Identity\User\Domain\Model\User;
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
         * @var User|null $buyer
         */
        $buyer = $this->queryBus->ask(new FindUserQuery($command->buyerId));

        if (null === $buyer) {
            throw new MissingUserException($command->buyerId);
        }

        $bookOrder = new Order(
            $book,
            $buyer,
        );

        $this->bookOrderRepository->save($bookOrder);

        return $bookOrder;
    }
}
