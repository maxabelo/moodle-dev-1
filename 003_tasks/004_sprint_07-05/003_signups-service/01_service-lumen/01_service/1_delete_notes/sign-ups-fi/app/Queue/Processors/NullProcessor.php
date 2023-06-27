<?php

namespace App\Queue\Processors;

use Interop\Queue\Processor;
use Interop\Queue\Message;
use Interop\Queue\Context;


class NullProcessor implements Processor
{

    use ProcessesMessage;

    /**
     * @inheritDoc
     */
    public function process(Message $message, Context $context)
    {
        $this->logger->info("Event {$message->getHeader('type')} received");

        return self::ACK;

    }

}
