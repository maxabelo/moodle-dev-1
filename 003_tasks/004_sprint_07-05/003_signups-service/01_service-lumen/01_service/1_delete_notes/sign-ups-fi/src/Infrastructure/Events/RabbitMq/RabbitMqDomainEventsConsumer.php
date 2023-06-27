<?php

namespace Infrastructure\Events\RabbitMq;

use App\Queue\Extensions\LogProcessorExceptionExtension;
use App\Queue\Processors\EventTypeDelegateProcessor;
use Enqueue\Consumption\ChainExtension;
use Enqueue\Consumption\Extension\LimitConsumedMessagesExtension;
use Enqueue\Consumption\Extension\LimitConsumerMemoryExtension;
use Enqueue\Consumption\Extension\LimitConsumptionTimeExtension;
use Enqueue\SimpleClient\SimpleClient;
use Psr\Log\LoggerInterface;


final class RabbitMqDomainEventsConsumer
{
    /**
     * @var int $messagesLimit
     */
    private $messagesLimit = 100;

    /**
     * @var \DateTime
     */
    private $timeLimit;

    /**
     * @var int $memoryLimit
     */
    private $memoryLimit = 50;

    /**
     * @param SimpleClient $client
     * @param EventTypeDelegateProcessor $processor
     * @param LoggerInterface $logger
     */
    public function __construct(
        private SimpleClient               $client,
        private EventTypeDelegateProcessor $processor,
        private LoggerInterface            $logger,
    )
    {

    }

    /**
     * @param array $argumentsIOExtend
     *
     * @return void
     * @throws \Exception
     */
    public function consume(array $argumentsIOExtend) : void
    {
        //Get configured queue
        $queue = $this->client
            ->getDriver()
            ->getConfig()
            ->getRouterQueue();

        $QueueConsumer = $this->client->getQueueConsumer();

        //bind queue to the event type processor delegator -- tienes 1 solo procesador q esta escuchando los eventos. Este procesador delega a otros procesadores el manejo de estos eventos
            // lo hace x medio del Arr de Processors q hemos visto en el   `QueueServiceProvider` > $processors  <- en este caso en el QueueService
        $this->setLimitsArguments($argumentsIOExtend);
        if (!empty($QueueConsumer)) {
            $QueueConsumer->bind($queue, $this->processor);
        }

        //consume! -- Consumer con Extensiones de SimpleClient para limitar el uso de recursos
        $QueueConsumer->consume(new ChainExtension([
            new LogProcessorExceptionExtension($this->logger),
            new LimitConsumedMessagesExtension($this->messagesLimit),
            new LimitConsumptionTimeExtension($this->timeLimit),
            new LimitConsumerMemoryExtension($this->memoryLimit)
        ]));
    }

    /**
     * @param $argumentsIOExtend
     *
     * @return void
     */
    private function setLimitsArguments($argumentsIOExtend)
    {
        $messagesLimit = config("enqueue.limit.messages");
        if (isset($argumentsIOExtend['message-limit'])) {
            $messagesLimit = $argumentsIOExtend['message-limit'];
        }

        $timeLimit = $this->getDataTimeBySeconds(config("enqueue.limit.time"));
        if (isset($argumentsIOExtend['time-limit'])) {
            $timeLimit = $this->getDataTimeBySeconds($argumentsIOExtend['time-limit']);
        }

        $memoryLimit = config("enqueue.limit.memory");
        if (isset($argumentsIOExtend['memory-limit'])) {
            $memoryLimit = $argumentsIOExtend['memory-limit'];
        }

        $this->messagesLimit = (int) $messagesLimit;
        $this->timeLimit = $timeLimit;
        $this->memoryLimit = (int) $memoryLimit;
    }

    /**
     * @param $seconds
     *
     * @return \DateTime|false
     */
    private function getDataTimeBySeconds($seconds)
    {
        $time = new \DateTime('now');

        return date_modify($time, '+ '. $seconds . ' second');
    }
}
