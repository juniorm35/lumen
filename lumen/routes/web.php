<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "hola";//$router->app->version();
});

$router->post('/users', 'UserController@create');
$router->get('/users', 'UserController@index');
$router->get('/users/{id}', 'UserController@show');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');

$router->post('/login', 'LoginController@login');
$router->post('/register', 'UserController@create');
$router->post('/sensor-data', 'SensorDataController@store');
$router->get('/sensor-data', 'SensorDataController@index');