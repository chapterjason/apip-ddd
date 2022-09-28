<?php

declare(strict_types=1);

namespace App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BookStore\Book\Domain\ValueObject\BookId;
use App\BookStore\Order\Application\Command\CreateOrderCommand;
use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Infrastructure\ApiPlatform\Resource\OrderResource;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Shared\Application\Command\CommandBusInterface;
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
