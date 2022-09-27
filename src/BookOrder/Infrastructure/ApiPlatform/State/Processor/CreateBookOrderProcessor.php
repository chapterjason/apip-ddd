<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BookOrder\Application\Command\CreateBookOrderCommand;
use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\ValueObject\BookId;
use App\BookOrder\Domain\ValueObject\UserId;
use App\BookOrder\Infrastructure\ApiPlatform\Resource\BookOrderResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class CreateBookOrderProcessor implements ProcessorInterface
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
        Assert::notNull($data->userId);
        Assert::notNull($data->bookId);

        $command = new CreateBookOrderCommand(
            new BookId($data->bookId),
            new UserId($data->userId),
        );

        /** @var BookOrder $model */
        $model = $this->commandBus->dispatch($command);

        return BookOrderResource::fromModel($model);
    }
}
