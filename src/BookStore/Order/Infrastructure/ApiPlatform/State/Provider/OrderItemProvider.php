<?php

declare(strict_types=1);

namespace App\BookStore\Order\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\BookStore\Order\Application\Query\FindOrderQuery;
use App\BookStore\Order\Domain\Model\Order;
use App\BookStore\Order\Domain\ValueObject\OrderId;
use App\BookStore\Order\Infrastructure\ApiPlatform\Resource\OrderResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

final class OrderItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @return OrderResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        /** @var Order|null $model */
        $model = $this->queryBus->ask(new FindOrderQuery(new OrderId(Uuid::fromString($id))));

        return null !== $model ? OrderResource::fromModel($model) : null;
    }
}
