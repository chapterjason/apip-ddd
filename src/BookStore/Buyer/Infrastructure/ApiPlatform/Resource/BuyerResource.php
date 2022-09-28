<?php

declare(strict_types=1);

namespace App\BookStore\Buyer\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\BookStore\Buyer\Domain\Model\Buyer;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor\CreateBuyerProcessor;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor\DeleteBuyerProcessor;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor\UpdateBuyerProcessor;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Provider\BuyerCollectionProvider;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Provider\BuyerItemProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Buyer',
    operations: [
        // queries

        // commands

        // basic crud
        new GetCollection(
            provider: BuyerCollectionProvider::class,
        ),
        new Get(
            provider: BuyerItemProvider::class,
        ),
        new Post(
            validationContext: ['groups' => ['create']],
            processor: CreateBuyerProcessor::class,
        ),
        new Put(
            provider: BuyerItemProvider::class,
            processor: UpdateBuyerProcessor::class
        ),
        new Patch(
            provider: BuyerItemProvider::class,
            processor: UpdateBuyerProcessor::class,
        ),
        new Delete(
            provider: BuyerItemProvider::class,
            processor: DeleteBuyerProcessor::class,
        ),
    ],
)]
final class BuyerResource
{
    public function __construct(
        #[ApiProperty(identifier: true, readable: false, writable: false)]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        #[Assert\Email(groups: ['create', 'Default'])]
        public ?string $email = null,
    ) {
    }

    public static function fromModel(Buyer $buyer): static
    {
        return new self(
            $buyer->id->value,
            $buyer->email->value,
        );
    }
}
