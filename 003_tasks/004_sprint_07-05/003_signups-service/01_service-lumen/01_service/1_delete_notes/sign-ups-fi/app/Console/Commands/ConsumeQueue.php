<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Infrastructure\Events\RabbitMq\RabbitMqDomainEventsConsumer;
use Psr\Log\LoggerInterface;


class ConsumeQueue extends Command
{
    /**
     * The name and signature of the console command.
     * execute `php /app/artisan queue:consume --message-limit=200 --time-limit=20 --memory-limit=50` in container
     */
    // comando propio de artisan 
    protected $signature = 'queue:consume
                            {--message-limit= : Consume n messages and exit type int }
                            {--time-limit= : Consume messages during this time in seconds }
                            {--memory-limit= : Consume messages until process reaches this memory limit in MB }';


    /**
     * The command arguments with their respective values
     */
    protected $commandArguments = [];
    /**
     * The console command description.
     */
    protected $description = 'Starts the rabbitmq queue consume';

    /**
     * @param RabbitMqDomainEventsConsumer $domainEventsConsumer
     * @param LoggerInterface $logger
     */
    public function __construct(
        private RabbitMqDomainEventsConsumer $domainEventsConsumer,
        private LoggerInterface $logger,
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function handle() : void
    {
        $this->setArgumentsCommand();

        $this->logger->notice(sprintf(
            'Starting to consume the %s RabbitMQ queue ...',
            env('APP_NAME')
        ));
        try{
            $this->domainEventsConsumer
            ->consume($this->commandArguments);
        }catch( \Exception $e){
            $this->logger->notice(sprintf(
                'Error to consume the %s RabbitMQ queue ... ' .
                $this->signature . ' ' .
                $e->getMessage() . ' ' . $e->getTraceAsString()
                ,
                env('APP_NAME')
            ));
        }
    }

    /**
     * @return array|mixed
     */
    private function setArgumentsCommand(){

        if(!empty($this->option("message-limit"))){
            $this->commandArguments["message-limit"] = $this->option("message-limit");
        }

        if(!empty($this->option("time-limit"))){
            $this->commandArguments["time-limit"] = $this->option("time-limit");
        }

        if(!empty($this->option("memory-limit"))){
            $this->commandArguments["memory-limit"] = $this->option("memory-limit");
        }

        return $this->commandArguments;
    }
}
