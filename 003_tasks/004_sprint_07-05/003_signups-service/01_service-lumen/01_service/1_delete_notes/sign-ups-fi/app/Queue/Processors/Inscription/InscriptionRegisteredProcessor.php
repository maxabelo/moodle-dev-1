<?php

namespace App\Queue\Processors\Inscription;

use App\Queue\Processors\ProcessesMessage;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;

class InscriptionRegisteredProcessor implements Processor
{

    use ProcessesMessage;

    public function process(Message $message, Context $context)
    {
        $this->logger->info("Queue ". $message->getHeader('type') . $message->getBody());

        return self::ACK;
    }
}
