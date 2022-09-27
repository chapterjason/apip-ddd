<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\ApiPlatform\OpenApi;

use ApiPlatform\Api\FilterInterface;
use Symfony\Component\PropertyInfo\Type;

final class AuthorFilter implements FilterInterface
{
    public function getDescription(string $resourceClass): array
    {
        return [
            'author' => [
                'property' => 'author',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
        ];
    }
}
