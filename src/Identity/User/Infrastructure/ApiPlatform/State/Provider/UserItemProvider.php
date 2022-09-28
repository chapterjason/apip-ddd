<?php

declare(strict_types=1);

namespace App\Identity\User\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Identity\User\Application\Query\FindUserQuery;
use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Identity\User\Infrastructure\ApiPlatform\Resource\UserResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

final class UserItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @return UserResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        /** @var User|null $model */
        $model = $this->queryBus->ask(new FindUserQuery(new UserId(Uuid::fromString($id))));

        return null !== $model ? UserResource::fromModel($model) : null;
    }
}
