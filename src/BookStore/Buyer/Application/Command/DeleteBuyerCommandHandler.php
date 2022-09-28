<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Command;

use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class DeleteBuyerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function __invoke(DeleteBuyerCommand $command): void
    {
        if (null === $buyer = $this->buyerRepository->ofId($command->id)) {
            return;
        }

        $this->buyerRepository->remove($buyer);
    }
}
