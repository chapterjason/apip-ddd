<?php

declare(strict_types=1);

use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Order\Infrastructure\Doctrine\DoctrineOrderRepository;
use App\Order\Infrastructure\InMemory\InMemoryOrderRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // repositories
    $services->set(OrderRepositoryInterface::class)
        ->class(InMemoryOrderRepository::class);

    $services->set(InMemoryOrderRepository::class)
        ->public();

    $services->set(DoctrineOrderRepository::class)
        ->public();
};
