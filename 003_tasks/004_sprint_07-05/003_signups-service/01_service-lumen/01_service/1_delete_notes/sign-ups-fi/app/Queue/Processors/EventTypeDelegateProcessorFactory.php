<?php

namespace App\Queue\Processors;

use Enqueue\ArrayProcessorRegistry;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\{ContainerInterface, NotFoundExceptionInterface};

final class EventTypeDelegateProcessorFactory
{

    /**
     * @param ContainerInterface $container
     */
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @param array $processors
     * @return EventTypeDelegateProcessor
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(array $processors): EventTypeDelegateProcessor
    {
        $processorRegistry = new ArrayProcessorRegistry();

        //add all the defined processors
        foreach ($processors as $eventType => $processor)
            $processorRegistry->add($eventType, $this->container->get($processor));

        return new EventTypeDelegateProcessor($processorRegistry);
    }

}
