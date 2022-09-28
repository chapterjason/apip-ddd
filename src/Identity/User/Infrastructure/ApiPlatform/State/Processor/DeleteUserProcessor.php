<?php

declare(strict_types=1);

namespace App\Identity\User\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Identity\User\Application\Command\DeleteUserCommand;
use App\Identity\User\Domain\ValueObject\UserId;
use App\Identity\User\Infrastructure\ApiPlatform\Resource\UserResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class DeleteUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param UserResource|mixed $data
     *
     * @return null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, UserResource::class);

        $this->commandBus->dispatch(new DeleteUserCommand(new UserId($data->id)));

        return null;
    }
}
