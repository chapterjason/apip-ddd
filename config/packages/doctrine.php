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
                        'dir' => '%kernel.project_dir%/src/Book/Domain',
                        'prefix' => 'App\Book\Domain',
                    ],
                    'Order' => [
                        'is_bundle' => false,
                        'type' => 'attribute',
                        'dir' => '%kernel.project_dir%/src/Order/Domain',
                        'prefix' => 'App\Order\Domain',
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
                        'dir' => '%kernel.project_dir%/src/User/Domain',
                        'prefix' => 'App\User\Domain',
                    ],
                ],
            ],
        ],
    );
};
