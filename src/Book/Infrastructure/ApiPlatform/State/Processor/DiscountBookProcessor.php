<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Book\Application\Command\DiscountBookCommand;
use App\Book\Application\Query\FindBookQuery;
use App\Book\Domain\Model\Book;
use App\Book\Domain\ValueObject\BookId;
use App\Book\Domain\ValueObject\Discount;
use App\Book\Infrastructure\ApiPlatform\Payload\DiscountBookPayload;
use App\Book\Infrastructure\ApiPlatform\Resource\BookResource;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use Webmozart\Assert\Assert;

final class DiscountBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @param mixed $data
     *
     * @return BookResource
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, DiscountBookPayload::class);

        $bookResource = $context['previous_data'];
        Assert::isInstanceOf($bookResource, BookResource::class);

        $command = new DiscountBookCommand(
            new BookId($bookResource->id),
            new Discount($data->discountPercentage),
        );

        $this->commandBus->dispatch($command);

        /** @var Book $model */
        $model = $this->queryBus->ask(new FindBookQuery($command->id));

        return BookResource::fromModel($model);
    }
}
