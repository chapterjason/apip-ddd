<?php

declare(strict_types=1);

namespace App\BookOrder\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\BookOrder\Application\Query\FindBookOrdersQuery;
use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\BookOrder\Infrastructure\ApiPlatform\Resource\BookOrderResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\ApiPlatform\State\Paginator;

final class BookOrderCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private Pagination $pagination,
    ) {
    }

    /**
     * @return Paginator<BookOrderResource>|list<BookOrderResource>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        /** @var BookOrderRepositoryInterface $models */
        $models = $this->queryBus->ask(new FindBookOrdersQuery($offset, $limit));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = BookOrderResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                (float) $paginator->getCurrentPage(),
                (float) $paginator->getItemsPerPage(),
                (float) $paginator->getLastPage(),
                (float) $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
