<?php

use App\Http\Resources\Schemas\Student as StudentSchema;
use App\Http\Resources\Schemas\Inscription as InscriptionSchema;
use Domain\Student\Student;
use Domain\Inscription\Inscription;

return [

    /*
    |--------------------------------------------------------------------------
    | API Schemas
    |--------------------------------------------------------------------------
    |
    | This file stores the configurations between Entities and its Schemas
    | to generate JSON:API Resources
    |
    */

    Student::class => StudentSchema::class,
    Inscription::class => InscriptionSchema::class
];

