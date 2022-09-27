<?php

declare(strict_types=1);

use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Order\Infrastructure\ApiPlatform\State\Processor\CreateOrderProcessor;
use App\Order\Infrastructure\ApiPlatform\State\Processor\DeleteOrderProcessor;
use App\Order\Infrastructure\ApiPlatform\State\Processor\UpdateOrderProcessor;
use App\Order\Infrastructure\ApiPlatform\State\Provider\OrderCollectionProvider;
use App\Order\Infrastructure\ApiPlatform\State\Provider\OrderItemProvider;
use App\Order\Infrastructure\Doctrine\DoctrineOrderRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\Order\\', __DIR__.'/../../src/Order');

    // providers
    $services->set(OrderItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    $services->set(OrderCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // processors
    $services->set(CreateOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(UpdateOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(DeleteOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    // repositories
    $services->set(OrderRepositoryInterface::class)
        ->class(DoctrineOrderRepository::class);
};
