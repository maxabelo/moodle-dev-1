<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enqueue Client Configuration @see: https://github.com/php-enqueue/enqueue-dev/blob/master/docs/bundle/config_reference.md
    |--------------------------------------------------------------------------
    |
    */

    // configuracion de conexion a RabbitMQ - SimpleClient lo facilita
    'client' => [
        'transport' => [
            'dsn' => env('ENQUEUE_DSN', 'amqp:'),
        ],
        'client' => [
            'router_topic' => env('RABBITMQ_EXCHANGE', 'academic-administration.sign-ups'), // Exchange Name
            'router_queue' => env('RABBITMQ_QUEUE', 'academic-administration.sign-ups'),
            'default_queue' => env('RABBITMQ_QUEUE', 'academic-administration.sign-ups'),
            'prefix' => '',
            'separator' => '.',
            'app_name' => '' // Consumer Queue
        ],
        'extensions' => [
            'reply_extension' => true,
        ]
    ],
    'limit' => [
        'messages' => env('ENQUEUE_MESSAGES_LIMIT', 100), //Limit of number of messages in int
        'time' =>  env('ENQUEUE_TIME_LIMIT', 10), //Time limit in seconds
        'memory' => env('ENQUEUE_MEMORY_LIMIT', 50), //Memory limit in megabytes
    ]
];
