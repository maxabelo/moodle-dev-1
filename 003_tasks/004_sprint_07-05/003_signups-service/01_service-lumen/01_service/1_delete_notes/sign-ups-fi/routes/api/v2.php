<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| SignUps Microservice REST API Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Home Default route.
|--------------------------------------------------------------------------
*/
$router->get('/sign-ups', function () {
    return response()->json([
        'message' => 'This is the Students Sign-Ups & Updates Microservice 2.0'
    ]);
});

/*
|--------------------------------------------------------------------------
| Student Handling Routes.
|--------------------------------------------------------------------------
*/

$router->get('/sign-ups/students/{id}', [
    'uses' => 'StudentsController@get',
    'as' => 'students.get'
]);

$router->get('/sign-ups/students', [
    'uses' => 'StudentsController@getAll',
    'as' => 'students.getAll'
]);


/*
|--------------------------------------------------------------------------
| Inscription Handling Routes.
|--------------------------------------------------------------------------
*/

$router->get('/sign-ups/inscriptions/{id}', [
    'uses' => 'InscriptionsController@get',
    'as' => 'inscriptions.get'
]);

$router->get('/sign-ups/inscriptions', [
    'uses' => 'InscriptionsController@getAll',
    'as' => 'inscriptions.getAll'
]);
