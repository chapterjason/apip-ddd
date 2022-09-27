<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Book\Domain\ValueObject\BookId;
use App\Order\Application\Command\UpdateOrderCommand;
use App\Order\Domain\Model\Order;
use App\Order\Domain\ValueObject\OrderId;
use App\Order\Infrastructure\ApiPlatform\Resource\OrderResource;
use App\Shared\Application\Command\CommandBusInterface;
use App\User\Domain\ValueObject\UserId;
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
            null !== $data->buyerId ? new UserId($data->buyerId) : null,
        );

        /** @var Order $model */
        $model = $this->commandBus->dispatch($command);

        return OrderResource::fromModel($model);
    }
}
