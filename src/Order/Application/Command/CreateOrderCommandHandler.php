<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Book\Application\Query\FindBookQuery;
use App\Book\Domain\Exception\MissingBookException;
use App\Book\Domain\Model\Book;
use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\User\Application\Query\FindUserQuery;
use App\User\Domain\Exception\MissingUserException;
use App\User\Domain\Model\User;

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
