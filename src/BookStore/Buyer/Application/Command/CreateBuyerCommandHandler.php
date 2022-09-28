<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Command;

use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class CreateBuyerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function __invoke(CreateBuyerCommand $command): Buyer
    {
        $buyer = new Buyer(
            $command->email,
        );

        $this->buyerRepository->save($buyer);

        return $buyer;
    }
}
