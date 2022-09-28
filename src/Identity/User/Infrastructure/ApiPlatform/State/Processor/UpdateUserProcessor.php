<?php

declare(strict_types=1);

namespace App\Identity\User\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Identity\User\Application\Command\UpdateUserCommand;
use App\Identity\User\Domain\Model\User;
use App\Identity\User\Domain\ValueObject\UserEmail;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Identity\User\Infrastructure\ApiPlatform\Resource\UserResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class UpdateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param UserResource|mixed $data
     *
     * @return UserResource
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, UserResource::class);

        $command = new UpdateUserCommand(
            new UserId($data->id),
            null !== $data->email ? new UserEmail($data->email) : null
        );

        /** @var User $model */
        $model = $this->commandBus->dispatch($command);

        return UserResource::fromModel($model);
    }
}
