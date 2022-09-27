<?php

declare(strict_types=1);

use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Book\Infrastructure\ApiPlatform\State\Processor\AnonymizeBooksProcessor;
use App\Book\Infrastructure\ApiPlatform\State\Processor\CreateBookProcessor;
use App\Book\Infrastructure\ApiPlatform\State\Processor\DeleteBookProcessor;
use App\Book\Infrastructure\ApiPlatform\State\Processor\DiscountBookProcessor;
use App\Book\Infrastructure\ApiPlatform\State\Processor\UpdateBookProcessor;
use App\Book\Infrastructure\ApiPlatform\State\Provider\BookCollectionProvider;
use App\Book\Infrastructure\ApiPlatform\State\Provider\BookItemProvider;
use App\Book\Infrastructure\ApiPlatform\State\Provider\CheapestBooksProvider;
use App\Book\Infrastructure\Doctrine\DoctrineBookRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\Book\\', __DIR__.'/../../src/Book');

    // providers
    $services->set(CheapestBooksProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 1]);

    $services->set(BookItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    $services->set(BookCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // processors
    $services->set(AnonymizeBooksProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 1]);

    $services->set(DiscountBookProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 1]);

    $services->set(CreateBookProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(UpdateBookProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(DeleteBookProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    // repositories
    $services->set(BookRepositoryInterface::class)
        ->class(DoctrineBookRepository::class);
};
