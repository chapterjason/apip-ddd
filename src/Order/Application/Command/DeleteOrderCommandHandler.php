<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class DeleteOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly OrderRepositoryInterface $bookOrderRepository)
    {
    }

    public function __invoke(DeleteOrderCommand $command): void
    {
        if (null === $bookOrder = $this->bookOrderRepository->ofId($command->id)) {
            return;
        }

        $this->bookOrderRepository->remove($bookOrder);
    }
}
