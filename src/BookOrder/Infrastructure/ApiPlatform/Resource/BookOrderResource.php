<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Infrastructure\ApiPlatform\State\Processor\CreateBookOrderProcessor;
use App\BookOrder\Infrastructure\ApiPlatform\State\Processor\DeleteBookOrderProcessor;
use App\BookOrder\Infrastructure\ApiPlatform\State\Processor\UpdateBookOrderProcessor;
use App\BookOrder\Infrastructure\ApiPlatform\State\Provider\BookOrderCollectionProvider;
use App\BookOrder\Infrastructure\ApiPlatform\State\Provider\BookOrderItemProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'BookOrder',
    operations: [
        // queries

        // commands

        // basic crud
        new GetCollection(
            provider: BookOrderCollectionProvider::class,
        ),
        new Get(
            provider: BookOrderItemProvider::class,
        ),
        new Post(
            validationContext: ['groups' => ['create']],
            processor: CreateBookOrderProcessor::class,
        ),
        new Put(
            provider: BookOrderItemProvider::class,
            processor: UpdateBookOrderProcessor::class
        ),
        new Patch(
            provider: BookOrderItemProvider::class,
            processor: UpdateBookOrderProcessor::class,
        ),
        new Delete(
            provider: BookOrderItemProvider::class,
            processor: DeleteBookOrderProcessor::class,
        ),
    ],
)]
final class BookOrderResource
{
    public function __construct(
        #[ApiProperty(identifier: true, readable: false, writable: false)]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?AbstractUid $bookId = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?AbstractUid $userId = null,
    ) {
    }

    public static function fromModel(BookOrder $bookOrder): static
    {
        return new self(
            $bookOrder->id->value,
            $bookOrder->bookId->value,
            $bookOrder->userId->value,
        );
    }
}
