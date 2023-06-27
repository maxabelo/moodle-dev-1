<?php

namespace Infrastructure\Common\Bus\Middleware;

use Ddd\Domain\Events\EventDispatcher;
use League\Tactician\Middleware;

/**
 * Dispatch Events using an EventDispatcher
 *
 * This middleware allows to avoid coupling between the Command Handlers
 * and the event dispatching logic.
 */
class EventDispatcherMiddleware implements Middleware
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $this->eventDispatcher->dispatch();

        return $returnValue;
    }
}
