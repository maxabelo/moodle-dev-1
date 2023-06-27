<?php

namespace App\Queue\Processors;

use App\Http\Resources\ResourceManager;
use Interop\Queue\Message;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;



trait ProcessesMessage
{
    protected $logger;

    protected $bus;

    public function __construct(
        LoggerInterface $logger,
        CommandBus $bus
    ){
        $this->logger = $logger;
        $this->bus = $bus;
    }

    /**
     * @inheritDoc
     */
    protected function getMessagePayload(Message $message) : array
    {
        return json_decode($message->getBody(), true);
    }

    protected function createResponse($resource, $code = 200)
    {
        return json_encode(
            ResourceManager::encode($resource), JSON_UNESCAPED_SLASHES
        );
    }


}
