<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Book\Application\Command\CreateBookCommand;
use App\Book\Domain\Model\Book;
use App\Book\Domain\ValueObject\Author;
use App\Book\Domain\ValueObject\BookContent;
use App\Book\Domain\ValueObject\BookDescription;
use App\Book\Domain\ValueObject\BookName;
use App\Book\Domain\ValueObject\Price;
use App\Book\Infrastructure\ApiPlatform\Resource\BookResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class CreateBookProcessor implements ProcessorInterface
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

        Assert::notNull($data->name);
        Assert::notNull($data->description);
        Assert::notNull($data->author);
        Assert::notNull($data->content);
        Assert::notNull($data->price);

        $command = new CreateBookCommand(
            new BookName($data->name),
            new BookDescription($data->description),
            new Author($data->author),
            new BookContent($data->content),
            new Price($data->price),
        );

        /** @var Book $model */
        $model = $this->commandBus->dispatch($command);

        return BookResource::fromModel($model);
    }
}
