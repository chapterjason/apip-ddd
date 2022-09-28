<?php

declare(strict_types=1);

namespace App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BookStore\Book\Domain\ValueObject\BookId;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\BookStore\Order\Application\Command\UpdateOrderCommand;
use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Domain\ValueObject\OrderId;
use App\BookStore\Order\Infrastructure\ApiPlatform\Resource\OrderResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class UpdateOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param OrderResource|mixed $data
     *
     * @return OrderResource
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, OrderResource::class);

        $command = new UpdateOrderCommand(
            new OrderId($data->id),
            null !== $data->bookId ? new BookId($data->bookId) : null,
            null !== $data->buyerId ? new BuyerId($data->buyerId) : null,
        );

        /** @var Order $model */
        $model = $this->commandBus->dispatch($command);

        return OrderResource::fromModel($model);
    }
}
