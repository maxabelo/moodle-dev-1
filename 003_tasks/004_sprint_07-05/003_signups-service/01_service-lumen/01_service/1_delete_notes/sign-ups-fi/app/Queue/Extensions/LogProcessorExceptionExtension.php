<?php

namespace App\Queue\Extensions;

use Enqueue\Consumption\Context\ProcessorException;
use Enqueue\Consumption\ProcessorExceptionExtensionInterface;
use Enqueue\Consumption\Result;
use Psr\Log\LoggerInterface;

class LogProcessorExceptionExtension implements ProcessorExceptionExtensionInterface
{

    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function onProcessorException(ProcessorException $context): void
    {
        // Catch Any Exceptions in the Processor and send them to the logger
        // This is useful to log any possible problems when receiving a message
        $this->logger->debug(sprintf(
            'Message Rejected. Processor has thrown an exception: %s',
            $context->getException()->getMessage()
        ));

        // Discard the exception and set the Result as rejected
        $context->setResult(new Result(Result::REJECT));
    }

}
