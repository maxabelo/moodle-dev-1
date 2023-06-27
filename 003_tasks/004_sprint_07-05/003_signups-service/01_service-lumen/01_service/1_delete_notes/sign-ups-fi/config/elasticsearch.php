<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Databases
    |--------------------------------------------------------------------------
    |
    */

    'prefix' => env('ES_PREFIX',''),

    'type' => env('ES_TYPE', 'hosts'),

    'cloud' => [
        'id' => env('ES_CLOUD_ID'),
        'api_id' => env('ES_API_ID'), 
        'api_key' => env('ES_API_KEY'),
    ],
    
    'hosts' => [
        [
            'host' => env('ES_HOST', 'localhost'),
            'port' => env('ES_PORT', 9200),
        ]
    ]
];
