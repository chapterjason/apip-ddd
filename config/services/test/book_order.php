<?php

declare(strict_types=1);

use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\BookOrder\Infrastructure\Doctrine\DoctrineBookOrderRepository;
use App\BookOrder\Infrastructure\InMemory\InMemoryBookOrderRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // repositories
    $services->set(BookOrderRepositoryInterface::class)
        ->class(InMemoryBookOrderRepository::class);

    $services->set(InMemoryBookOrderRepository::class)
        ->public();

    $services->set(DoctrineBookOrderRepository::class)
        ->public();
};
