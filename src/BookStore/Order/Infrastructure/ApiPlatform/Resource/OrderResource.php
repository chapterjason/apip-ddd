<?php

declare(strict_types=1);

namespace App\BookStore\Order\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor\CreateOrderProcessor;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor\DeleteOrderProcessor;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor\UpdateOrderProcessor;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Provider\OrderCollectionProvider;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Provider\OrderItemProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Order',
    operations: [
        // queries

        // commands

        // basic crud
        new GetCollection(
            provider: OrderCollectionProvider::class,
        ),
        new Get(
            provider: OrderItemProvider::class,
        ),
        new Post(
            validationContext: ['groups' => ['create']],
            processor: CreateOrderProcessor::class,
        ),
        new Put(
            provider: OrderItemProvider::class,
            processor: UpdateOrderProcessor::class
        ),
        new Patch(
            provider: OrderItemProvider::class,
            processor: UpdateOrderProcessor::class,
        ),
        new Delete(
            provider: OrderItemProvider::class,
            processor: DeleteOrderProcessor::class,
        ),
    ],
)]
final class OrderResource
{
    public function __construct(
        #[ApiProperty(identifier: true, readable: false, writable: false)]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?AbstractUid $bookId = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?AbstractUid $buyerId = null,
    ) {
    }

    public static function fromModel(Order $bookOrder): static
    {
        return new self(
            $bookOrder->id->value,
            $bookOrder->book->id->value,
            $bookOrder->buyer->id->value,
        );
    }
}
