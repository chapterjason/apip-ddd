<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Command;

use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class CreateBookOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly BookOrderRepositoryInterface $bookOrderRepository,
    ) {
    }

    public function __invoke(CreateBookOrderCommand $command): BookOrder
    {
        $bookOrder = new BookOrder(
            $command->bookId,
            $command->userId,
        );

        $this->bookOrderRepository->save($bookOrder);

        return $bookOrder;
    }
}
