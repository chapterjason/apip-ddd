<?php

declare(strict_types=1);

use App\BookStore\Book\Domain\Repository\BookRepositoryInterface;
use App\BookStore\Book\Infrastructure\Doctrine\DoctrineBookRepository;
use App\BookStore\Book\Infrastructure\InMemory\InMemoryBookRepository;
use App\BookStore\Order\Domain\Repository\OrderRepositoryInterface;
use App\BookStore\Order\Infrastructure\Doctrine\DoctrineOrderRepository;
use App\BookStore\Order\Infrastructure\InMemory\InMemoryOrderRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // book repositories
    $services->set(BookRepositoryInterface::class)
        ->class(InMemoryBookRepository::class);

    $services->set(InMemoryBookRepository::class)
        ->public();

    $services->set(DoctrineBookRepository::class)
        ->public();

    // order repositories
    $services->set(OrderRepositoryInterface::class)
        ->class(InMemoryOrderRepository::class);

    $services->set(InMemoryOrderRepository::class)
        ->public();

    $services->set(DoctrineOrderRepository::class)
        ->public();
};
