<?php

declare(strict_types=1);

namespace App\BookOrder\Application\Command;

use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class DeleteBookOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BookOrderRepositoryInterface $bookOrderRepository)
    {
    }

    public function __invoke(DeleteBookOrderCommand $command): void
    {
        if (null === $bookOrder = $this->bookOrderRepository->ofId($command->id)) {
            return;
        }

        $this->bookOrderRepository->remove($bookOrder);
    }
}
