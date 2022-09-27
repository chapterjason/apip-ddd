<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Command;

use App\BookOrder\Domain\Exception\MissingBookOrderException;
use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class UpdateBookOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookOrderRepositoryInterface $bookOrderRepository)
    {
    }

    public function __invoke(UpdateBookOrderCommand $command): BookOrder
    {
        $bookOrder = $this->bookOrderRepository->ofId($command->id);

        if (null === $bookOrder) {
            throw new MissingBookOrderException($command->id);
        }

        $bookOrder->bookId = $command->bookId ?? $bookOrder->bookId;
        $bookOrder->userId = $command->userId ?? $bookOrder->userId;

        $this->bookOrderRepository->save($bookOrder);

        return $bookOrder;
    }
}
