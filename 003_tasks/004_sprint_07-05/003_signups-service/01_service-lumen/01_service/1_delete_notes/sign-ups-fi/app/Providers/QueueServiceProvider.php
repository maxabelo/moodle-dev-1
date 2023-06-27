<?php

namespace App\Providers;

use App\Queue\Processors\EventTypeDelegateProcessor;
use Enqueue\ArrayProcessorRegistry;
use Enqueue\SimpleClient\SimpleClient;
use Illuminate\Support\ServiceProvider;

class QueueServiceProvider extends ServiceProvider
{

    protected static $processors = [

        'events' => [
            // 2) cambiar la firma del evento: Eventos q ESCUCHA y su processor
            'academic-administration.sign-ups.student_registered' =>
                \App\Queue\Processors\Student\StudentRegisterSuccessedProcessor::class,

            'academic-administration.sign-ups.student_updated' =>
                \App\Queue\Processors\Student\StudentUpdatedProcessor::class,

            'academic-administration.sign-ups.student_signedup' =>
                \App\Queue\Processors\Student\StudentSignedUpProcessor::class,

            'academic-administration.sign-ups.inscription_registered' =>
                \App\Queue\Processors\Inscription\InscriptionRegisteredProcessor::class,

            // Proof of concept processor.
            'academic-administration.sign-ups.student_failed' =>
                \App\Queue\Processors\NullProcessor::class,
        ]
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->resolving(
            SimpleClient::class,
            function (SimpleClient $client, $container){
                $client->setupBroker(); // create exchange, queue
                return $client;
            }
        );

        $this->app->bind(
            'App\Queue\Processors\EventTypeDelegateProcessor',
            function($app){
                $registry = new ArrayProcessorRegistry([]);

                // Register each defined event processor by its type.
                foreach (static::$processors['events'] as $type => $processor){
                    $registry->add($type, $this->app->get($processor));
                }

                return new EventTypeDelegateProcessor($registry);
            }
        );
    }


}
