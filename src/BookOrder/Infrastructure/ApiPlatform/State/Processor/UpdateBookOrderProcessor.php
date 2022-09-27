<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BookOrder\Application\Command\UpdateBookOrderCommand;
use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\ValueObject\BookId;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\BookOrder\Domain\ValueObject\UserId;
use App\BookOrder\Infrastructure\ApiPlatform\Resource\BookOrderResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class UpdateBookOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param BookOrderResource|mixed $data
     *
     * @return BookOrderResource
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, BookOrderResource::class);

        $command = new UpdateBookOrderCommand(
            new BookOrderId($data->id),
            null !== $data->bookId ? new BookId($data->bookId) : null,
            null !== $data->userId ? new UserId($data->userId) : null,
        );

        /** @var BookOrder $model */
        $model = $this->commandBus->dispatch($command);

        return BookOrderResource::fromModel($model);
    }
}
