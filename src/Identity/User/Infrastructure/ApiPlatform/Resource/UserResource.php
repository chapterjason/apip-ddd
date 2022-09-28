<?php

declare(strict_types=1);

namespace App\Identity\User\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Identity\User\Domain\Model\User;
use App\Identity\User\Infrastructure\ApiPlatform\State\Processor\CreateUserProcessor;
use App\Identity\User\Infrastructure\ApiPlatform\State\Processor\DeleteUserProcessor;
use App\Identity\User\Infrastructure\ApiPlatform\State\Processor\UpdateUserProcessor;
use App\Identity\User\Infrastructure\ApiPlatform\State\Provider\UserCollectionProvider;
use App\Identity\User\Infrastructure\ApiPlatform\State\Provider\UserItemProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    operations: [
        // queries

        // commands

        // basic crud
        new GetCollection(
            provider: UserCollectionProvider::class,
        ),
        new Get(
            provider: UserItemProvider::class,
        ),
        new Post(
            validationContext: ['groups' => ['create']],
            processor: CreateUserProcessor::class,
        ),
        new Put(
            provider: UserItemProvider::class,
            processor: UpdateUserProcessor::class
        ),
        new Patch(
            provider: UserItemProvider::class,
            processor: UpdateUserProcessor::class,
        ),
        new Delete(
            provider: UserItemProvider::class,
            processor: DeleteUserProcessor::class,
        ),
    ],
)]
final class UserResource
{
    public function __construct(
        #[ApiProperty(identifier: true, readable: false, writable: false)]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $email = null,
    ) {
    }

    public static function fromModel(User $user): static
    {
        return new self(
            $user->id->value,
            $user->email->value,
        );
    }
}
