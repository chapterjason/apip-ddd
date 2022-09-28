<?php

declare(strict_types=1);

use App\BookStore\Book\Domain\Repository\BookRepositoryInterface;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Processor\AnonymizeBooksProcessor;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Processor\CreateBookProcessor;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Processor\DeleteBookProcessor;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Processor\DiscountBookProcessor;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Processor\UpdateBookProcessor;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Provider\BookCollectionProvider;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Provider\BookItemProvider;
use App\BookStore\Book\Infrastructure\ApiPlatform\State\Provider\CheapestBooksProvider;
use App\BookStore\Book\Infrastructure\Doctrine\DoctrineBookRepository;
use App\BookStore\Buyer\Domain\Repository\BuyerRepositoryInterface;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor\CreateBuyerProcessor;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor\DeleteBuyerProcessor;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Processor\UpdateBuyerProcessor;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Provider\BuyerCollectionProvider;
use App\BookStore\Buyer\Infrastructure\ApiPlatform\State\Provider\BuyerItemProvider;
use App\BookStore\Buyer\Infrastructure\Doctrine\DoctrineBuyerRepository;
use App\BookStore\Order\Domain\Repository\OrderRepositoryInterface;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor\CreateOrderProcessor;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor\DeleteOrderProcessor;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Processor\UpdateOrderProcessor;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Provider\OrderCollectionProvider;
use App\BookStore\Order\Infrastructure\ApiPlatform\State\Provider\OrderItemProvider;
use App\BookStore\Order\Infrastructure\Doctrine\DoctrineOrderRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\BookStore\\', __DIR__.'/../../src/BookStore');

    // book providers
    $services->set(CheapestBooksProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 1]);

    $services->set(BookItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    $services->set(BookCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // book processors
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

    // order providers
    $services->set(OrderItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    $services->set(OrderCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // order processors
    $services->set(CreateOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(UpdateOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(DeleteOrderProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    // buyer providers
    $services->set(BuyerItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    $services->set(BuyerCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // buyer processors
    $services->set(CreateBuyerProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(UpdateBuyerProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(DeleteBuyerProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    // book repositories
    $services->set(BookRepositoryInterface::class)
        ->class(DoctrineBookRepository::class);

    // order repositories
    $services->set(OrderRepositoryInterface::class)
        ->class(DoctrineOrderRepository::class);

    // buyer repositories
    $services->set(BuyerRepositoryInterface::class)
        ->class(DoctrineBuyerRepository::class);
};
