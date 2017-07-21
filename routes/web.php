<?php

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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'v1'], function($app)
{
    $app->post('auth/login', 'AuthController@loginPost');
});

/*$app->group(['prefix' => 'v1'], function ($app)
{  
    $app->get('employee/{username}','EmployeeController@getEmployeeByUsername');

    $app->get('student/{username}','StudentController@getStudentByUsername');
});*/

$app->group(['prefix' => 'v1', 'middleware' => 'auth'], function ($app)
{  
    $app->get('employee/{username}','EmployeeController@getEmployeeByUsername');

    $app->get('student/{username}','StudentController@getStudentByUsername');
});