<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Book\Application\Query\FindBookQuery;
use App\Book\Domain\Exception\MissingBookException;
use App\Book\Domain\Model\Book;
use App\Order\Domain\Exception\MissingOrderException;
use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\User\Application\Query\FindUserQuery;
use App\User\Domain\Exception\MissingUserException;
use App\User\Domain\Model\User;

final class UpdateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $bookOrderRepository,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(UpdateOrderCommand $command): Order
    {
        $order = $this->bookOrderRepository->ofId($command->id);

        if (null === $order) {
            throw new MissingOrderException($command->id);
        }

        if (null !== $command->bookId) {
            /**
             * @var Book|null $book
             */
            $book = $this->queryBus->ask(new FindBookQuery($command->bookId));

            if (null === $book) {
                throw new MissingBookException($command->bookId);
            }

            $order->book = $book;
        }

        if (null !== $command->buyerId) {
            /**
             * @var User|null $buyer
             */
            $buyer = $this->queryBus->ask(new FindUserQuery($command->buyerId));

            if (null === $buyer) {
                throw new MissingUserException($command->buyerId);
            }

            $order->buyer = $buyer;
        }

        $this->bookOrderRepository->save($order);

        return $order;
    }
}
