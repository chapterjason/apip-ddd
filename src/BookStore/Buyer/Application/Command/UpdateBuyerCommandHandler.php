<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Command;

use App\BookStore\Buyer\Domain\Exception\MissingBuyerException;
use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class UpdateBuyerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function __invoke(UpdateBuyerCommand $command): Buyer
    {
        $buyer = $this->buyerRepository->ofId($command->id);

        if (null === $buyer) {
            throw new MissingBuyerException($command->id);
        }

        $buyer->email = $command->email ?? $buyer->email;

        $this->buyerRepository->save($buyer);

        return $buyer;
    }
}
