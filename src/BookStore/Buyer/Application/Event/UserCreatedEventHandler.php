<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Application\Event;

use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\BookStore\Buyer\Domain\ValueObject\BuyerEmail;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\IdentityIntegration\Application\Event\UserCreatedEvent;
use App\Shared\Application\Event\EventHandlerInterface;

class UserCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function __invoke(UserCreatedEvent $event): Buyer
    {
        $buyer = new Buyer(
            email: new BuyerEmail($event->email->value),
            id: new BuyerId($event->id->value),
        );

        $this->buyerRepository->save($buyer);

        return $buyer;
    }
}
