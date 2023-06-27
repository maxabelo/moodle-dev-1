<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global Data Connection Configuration
    |--------------------------------------------------------------------------
    |
    */

    'sirius' => [
        'name'=> env('NAME_SIRIUS'),
        'connection'=>  env('DB_CONNECTION_SIRIUS','mysql_sirius'),
        'database' => env('DB_DATABASE'),
        'institution'=> 'FUNIBER',
        'abbreviation' => 'FBR',
        'nameSpace'=> 'funiber.org'
    ],
    'guiaa' => [
        'name'=> env('NAME_GUIAA'),
        'connection'=> env('DB_CONNECTION_GUIAA','mysql_guiaa'),
        'database' => env('DB_DATABASE_GUIAA'),
        'institution'=> 'UNEATLANTICO',
        'abbreviation' => 'UEA',
        'nameSpace'=> 'uneatlantico.es'
    ],
    'unic' => [
        'name'=> env('NAME_UNIC'),
        'connection'=> env('DB_CONNECTION_UNIC','mysql_unic'),
        'database' => env('DB_DATABASE_UNIC'),
        'institution'=> 'UNIC',
        'abbreviation' => 'UNIC',
        'nameSpace'=> 'unic.co.ao'
    ],
    'unincol' => [
        'name'=> env('NAME_UNINCOL'),
        'connection'=> env('DB_CONNECTION_UNINCOL','mysql_unincol'),
        'database' => env('DB_DATABASE_UNINCOL'),
        'institution'=> 'UNINCOL',
        'abbreviation' => 'UNINCOL',
        'nameSpace'=> 'unincol.edu.co'
    ],
    'unib' => [
        'abbreviation' => 'UNIB',
        'nameSpace'=> 'unib.org'
    ],
    'uninimx' => [
        'abbreviation' => 'UNINIMX',
        'nameSpace'=> 'unini.edu.mx'
    ],
    'uniromana' => [
        'abbreviation' => 'UNIROMANA',
        'nameSpace'=> 'uniromana.do'
    ]
];
