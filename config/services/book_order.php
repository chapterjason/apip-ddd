<?php

declare(strict_types=1);

use App\BookOrder\Domain\Repository\BookOrderRepositoryInterface;
use App\BookOrder\Infrastructure\ApiPlatform\State\Processor\CreateBookOrderProcessor;
use App\BookOrder\Infrastructure\ApiPlatform\State\Processor\DeleteBookOrderProcessor;
use App\BookOrder\Infrastructure\ApiPlatform\State\Processor\UpdateBookOrderProcessor;
use App\BookOrder\Infrastructure\ApiPlatform\State\Provider\BookOrderCollectionProvider;
use App\BookOrder\Infrastructure\ApiPlatform\State\Provider\BookOrderItemProvider;
use App\BookOrder\Infrastructure\Doctrine\DoctrineBookOrderRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\BookOrder\\', __DIR__.'/../../src/BookOrder');

    // providers
    $services->set(BookOrderItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    $services->set(BookOrderCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // processors
    $services->set(CreateBookOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(UpdateBookOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(DeleteBookOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    // repositories
    $services->set(BookOrderRepositoryInterface::class)
        ->class(DoctrineBookOrderRepository::class);
};
