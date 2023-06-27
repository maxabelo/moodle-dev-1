<?php

namespace Infrastructure\Common\Bus\Middleware;

use Ddd\Domain\Events\Event;
use Ddd\Domain\Events\EventCollector;
use Ddd\Domain\Events\IntegrationEvent;
use Enqueue\Client\Message;
use Enqueue\SimpleClient\SimpleClient;
use League\Tactician\Middleware;

/**
 * Publish Integration Events using a Publisher
 *
 * This middleware allows to avoid coupling between the Command Handlers
 * and the integration events publishing logic.
 */
class IntegrationEventPublisherMiddleware implements Middleware
{
    private $client;

    private $eventCollector;

    /**
     * @param SimpleClient $client
     * @param EventCollector $eventCollector
     */
    public function __construct(
        SimpleClient $client, EventCollector $eventCollector
    ){
        $this->client = $client;
        $this->eventCollector = $eventCollector;
    }

    /**
     * @param $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $events = $this->eventCollector->getEvents();

        foreach ($events as $event) {
            // Publish only integration events
            ($event instanceof IntegrationEvent) && $this->publishEvent($event);
        }

        return $returnValue;
    }


     /**
     * @param Event $event
     *
     * @return null
     */
    protected function publishEvent(Event $event)  // publicador del evento, el nombre de la queue viene de la EnvV
    {
        $message = new Message($event);

        // Set The Event UUID in the Rabbit Message.
        $message->setMessageId((string) $event->getEventId());

        // Set the Application ID in the Message.
        $message->setHeader('app_id', env('RABBITMQ_QUEUE', ''));

        // Set the Message Type (based on developer.ctec.dev conventions).
        // @see: https://developer.ctec.dev/microservices/architecture/#message-type-aka-event-signature
        $message->setHeader('type', env('RABBITMQ_QUEUE', '') . '.' . $event->getType());

        // $message->setScope(Message::SCOPE_MESSAGE_BUS);

        // // middleware q PUBLICA el evento
        return $this->client->sendEvent(env('RABBITMQ_QUEUE'), $message);
    }
}
