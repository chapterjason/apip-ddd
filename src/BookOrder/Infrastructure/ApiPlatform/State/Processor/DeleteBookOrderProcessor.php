<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BookOrder\Application\Command\DeleteBookOrderCommand;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\BookOrder\Infrastructure\ApiPlatform\Resource\BookOrderResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class DeleteBookOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param BookOrderResource|mixed $data
     *
     * @return null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, BookOrderResource::class);

        $this->commandBus->dispatch(new DeleteBookOrderCommand(new BookOrderId($data->id)));

        return null;
    }
}
