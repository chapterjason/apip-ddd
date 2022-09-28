<?php

declare(strict_types=1);

use App\Identity\User\Domain\Repository\UserRepositoryInterface;
use App\Identity\User\Infrastructure\ApiPlatform\State\Processor\CreateUserProcessor;
use App\Identity\User\Infrastructure\ApiPlatform\State\Processor\DeleteUserProcessor;
use App\Identity\User\Infrastructure\ApiPlatform\State\Processor\UpdateUserProcessor;
use App\Identity\User\Infrastructure\ApiPlatform\State\Provider\UserCollectionProvider;
use App\Identity\User\Infrastructure\ApiPlatform\State\Provider\UserItemProvider;
use App\Identity\User\Infrastructure\Doctrine\DoctrineUserRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\Identity\\', __DIR__.'/../../src/Identity');

    // user providers
    $services->set(UserItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    $services->set(UserCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // user processors
    $services->set(CreateUserProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(UpdateUserProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    $services->set(DeleteUserProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    // user repositories
    $services->set(UserRepositoryInterface::class)
        ->class(DoctrineUserRepository::class);
};
