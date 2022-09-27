<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Order\Application\Command\DeleteOrderCommand;
use App\Order\Domain\ValueObject\OrderId;
use App\Order\Infrastructure\ApiPlatform\Resource\OrderResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class DeleteOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param OrderResource|mixed $data
     *
     * @return null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, OrderResource::class);

        $this->commandBus->dispatch(new DeleteOrderCommand(new OrderId($data->id)));

        return null;
    }
}
