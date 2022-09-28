<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\BookStore\Buyer\Application\Query\FindBuyerQuery;
use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\Resource\BuyerResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

final class BuyerItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @return BuyerResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        /** @var Buyer|null $model */
        $model = $this->queryBus->ask(new FindBuyerQuery(new BuyerId(Uuid::fromString($id))));

        return null !== $model ? BuyerResource::fromModel($model) : null;
    }
}
