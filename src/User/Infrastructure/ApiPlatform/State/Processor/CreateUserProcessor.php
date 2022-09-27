<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\User\Application\Command\CreateUserCommand;
use App\User\Domain\Model\User;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Infrastructure\ApiPlatform\Resource\UserResource;
use Webmozart\Assert\Assert;

final class CreateUserProcessor implements ProcessorInterface
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
        Assert::notNull($data->email);

        $command = new CreateUserCommand(
            new UserEmail($data->email),
        );

        /** @var User $model */
        $model = $this->commandBus->dispatch($command);

        return UserResource::fromModel($model);
    }
}
