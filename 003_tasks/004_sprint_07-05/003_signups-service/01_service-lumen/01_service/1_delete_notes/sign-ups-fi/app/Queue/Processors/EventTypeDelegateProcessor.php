<?php

namespace App\Queue\Processors;

use Enqueue\ProcessorRegistryInterface;
use Interop\Queue\Context;
use Interop\Queue\Message as InteropMessage;
use Interop\Queue\Processor;


// delega q evento va hacia q processor
class EventTypeDelegateProcessor implements Processor
{
    const EVENT_TYPE_HEADER = 'type';

    /**
     * @var ProcessorRegistryInterface
     */
    private $registry = [];

    /**
     * @param ProcessorRegistryInterface $registry
     */
    public function __construct(ProcessorRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function process(InteropMessage $message, Context $context)
    {
        $processorName = $message->getHeader(self::EVENT_TYPE_HEADER);

        if (false == $processorName) {

            throw new \LogicException(sprintf(
                'Got message without required parameter: "%s"',
                self::EVENT_TYPE_HEADER
            ));
        }
        return $this->registry->get($processorName)->process($message, $context);
    }

}
