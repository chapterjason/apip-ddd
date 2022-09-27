<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Book\Domain\ValueObject\BookId;
use App\Order\Application\Command\CreateOrderCommand;
use App\Order\Domain\Model\Order;
use App\Order\Infrastructure\ApiPlatform\Resource\OrderResource;
use App\Shared\Application\Command\CommandBusInterface;
use App\User\Domain\ValueObject\UserId;
use Webmozart\Assert\Assert;

final class CreateOrderProcessor implements ProcessorInterface
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
        Assert::notNull($data->bookId);
        Assert::notNull($data->buyerId);

        $command = new CreateOrderCommand(
            new BookId($data->bookId),
            new UserId($data->buyerId),
        );

        /** @var Order $model */
        $model = $this->commandBus->dispatch($command);

        return OrderResource::fromModel($model);
    }
}
