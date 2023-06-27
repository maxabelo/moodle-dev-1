<?php

declare(strict_types=1);

namespace Infrastructure\Common\Bus;

use Ddd\Domain\Events\EventCollector;
use Ddd\Domain\Events\EventDispatcher;
use Enqueue\SimpleClient\SimpleClient;
use Psr\Container\ContainerInterface;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Plugins\LockingMiddleware;

class CommandBusFactory
{
    public function __invoke(ContainerInterface $container) : CommandBus
    {
        $lockingMiddleware = new LockingMiddleware();

         $eventDispatcherMiddleware = new Middleware\EventDispatcherMiddleware(
             $container->get(EventDispatcher::class)
         );
////
         $integrationEventPublisherMiddleware = new Middleware\IntegrationEventPublisherMiddleware(
             $container->get(SimpleClient::class),
             EventCollector::instance()
         );

        $handlerMiddleware = new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            new Locator\NamespacedHandlerLocator($container),
            new Inflector\ExecuteInflector()
        );

        return new CommandBus([
            $lockingMiddleware,
            $eventDispatcherMiddleware,
            $integrationEventPublisherMiddleware,
            $handlerMiddleware
        ]);
    }
}
