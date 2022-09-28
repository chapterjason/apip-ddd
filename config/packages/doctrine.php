<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'url' => '%env(resolve:DATABASE_URL)%',
            ],
            'orm' => [
                'auto_mapping' => true,
                'auto_generate_proxy_classes' => true,
                'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                'mappings' => [
                    'Book' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => '%kernel.project_dir%/src/BookStore/Book/Domain',
                        'prefix' => 'App\BookStore\Book\Domain',
                    ],
                    'Order' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => '%kernel.project_dir%/src/BookStore/Order/Domain',
                        'prefix' => 'App\BookStore\Order\Domain',
                    ],
                    'Buyer' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => '%kernel.project_dir%/src/BookStore/Buyer/Domain',
                        'prefix' => 'App\BookStore\Buyer\Domain',
                    ],
                    'Shared' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => '%kernel.project_dir%/src/Shared/Domain',
                        'prefix' => 'App\Shared\Domain',
                    ],
                    'Subscription' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => '%kernel.project_dir%/src/Subscription/Entity',
                        'prefix' => 'App\Subscription\Entity',
                    ],
                    'User' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => '%kernel.project_dir%/src/Identity/User/Domain',
                        'prefix' => 'App\Identity\User\Domain',
                    ],
                ],
            ],
        ],
    );
};
