<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BookStore\Buyer\Application\Command\DeleteBuyerCommand;
use App\BookStore\Buyer\Domain\ValueObject\BuyerId;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\Resource\BuyerResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class DeleteBuyerProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param mixed $data
     *
     * @return null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, BuyerResource::class);

        $this->commandBus->dispatch(new DeleteBuyerCommand(new BuyerId($data->id)));

        return null;
    }
}
