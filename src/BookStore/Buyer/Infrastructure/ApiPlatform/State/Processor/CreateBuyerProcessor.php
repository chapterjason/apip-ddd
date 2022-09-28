<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BookStore\Buyer\Application\Command\CreateBuyerCommand;
use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Domain\ValueObject\BuyerEmail;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\Resource\BuyerResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class CreateBuyerProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param mixed $data
     *
     * @return BuyerResource
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, BuyerResource::class);

        Assert::notNull($data->email);

        $command = new CreateBuyerCommand(
            new BuyerEmail($data->email),
        );

        /** @var Buyer $model */
        $model = $this->commandBus->dispatch($command);

        return BuyerResource::fromModel($model);
    }
}
