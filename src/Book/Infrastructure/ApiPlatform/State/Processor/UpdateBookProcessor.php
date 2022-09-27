<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Book\Application\Command\UpdateBookCommand;
use App\Book\Domain\Model\Book;
use App\Book\Domain\ValueObject\Author;
use App\Book\Domain\ValueObject\BookContent;
use App\Book\Domain\ValueObject\BookDescription;
use App\Book\Domain\ValueObject\BookId;
use App\Book\Domain\ValueObject\BookName;
use App\Book\Domain\ValueObject\Price;
use App\Book\Infrastructure\ApiPlatform\Resource\BookResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class UpdateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param mixed $data
     *
     * @return BookResource
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, BookResource::class);

        $command = new UpdateBookCommand(
            new BookId($data->id),
            null !== $data->name ? new BookName($data->name) : null,
            null !== $data->description ? new BookDescription($data->description) : null,
            null !== $data->author ? new Author($data->author) : null,
            null !== $data->content ? new BookContent($data->content) : null,
            null !== $data->price ? new Price($data->price) : null,
        );

        /** @var Book $model */
        $model = $this->commandBus->dispatch($command);

        return BookResource::fromModel($model);
    }
}
