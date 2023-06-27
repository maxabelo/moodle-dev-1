<?php

namespace Infrastructure\Common\Bus\Locator;

use Psr\Container\ContainerInterface;
use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;

/**
 * Fetch handler instances from an in-memory collection.
 *
 * This locator allows you to bind a handler FQCN to receive commands of a
 * certain command name.
 */
class NamespacedHandlerLocator implements HandlerLocator
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @param array              $commandNameToHandlerMap
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function getHandlerForCommand($commandName)
    {
        $serviceId = static::resolveHandlerForCommand($commandName);

        return $this->container->get($serviceId);
    }

    /**
     * Resolve a Handler FQCN from a command FQCN. 
     * 
     * Uses the term "Action" for the namespace and the Classname suffix
     * 
     * @throws MissingHandlerException
     */
    protected static function resolveHandlerForCommand($className)
    {
        $ns = explode("\\", $className);

        $handler = 
            join("\\", array_slice($ns, 0, -2)) . 
            "\\Handlers\\" . 
            array_pop($ns). 'Handler'
        ;

        if (!class_exists($handler)) {
            throw MissingHandlerException::forCommand($className);
        }

        return $handler;
    }
}
