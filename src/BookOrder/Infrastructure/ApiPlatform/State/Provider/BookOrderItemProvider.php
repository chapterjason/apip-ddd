<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\BookOrder\Application\Query\FindBookOrderQuery;
use App\BookOrder\Domain\Model\BookOrder;
use App\BookOrder\Domain\ValueObject\BookOrderId;
use App\BookOrder\Infrastructure\ApiPlatform\Resource\BookOrderResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

final class BookOrderItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @return BookOrderResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        /** @var BookOrder|null $model */
        $model = $this->queryBus->ask(new FindBookOrderQuery(new BookOrderId(Uuid::fromString($id))));

        return null !== $model ? BookOrderResource::fromModel($model) : null;
    }
}
