<?php

declare(strict_types=1);

use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Book\Infrastructure\Doctrine\DoctrineBookRepository;
use App\Book\Infrastructure\InMemory\InMemoryBookRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // repositories
    $services->set(BookRepositoryInterface::class)
        ->class(InMemoryBookRepository::class);

    $services->set(InMemoryBookRepository::class)
        ->public();

    $services->set(DoctrineBookRepository::class)
        ->public();
};
