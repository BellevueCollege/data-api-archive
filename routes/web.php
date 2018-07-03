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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*** Unprotected data endpoints ***/
$router->group(['prefix' => 'v1'], function () use ($router)
{
    $router->post('auth/login', 'AuthController@loginPost');

    $router->get('subject','SubjectController@index');
  
    $router->get('subject/{slug}','SubjectController@getSubject');
      
    $router->get('courses/multiple', 'CourseController@getMultipleCourses');
    //$router->get('courses/{courseid}','CourseController@getCourse');
    
    $router->get('quarters/current', 'YearQuarterController@getCurrentYearQuarter');
    
    //API endpoints specific to ModoLabs requirements
    $router->get('catalog/terms', 'YearQuarterController@getViewableYearQuarters');
    $router->get('catalog/terms/{yqrid}', 'YearQuarterController@getYearQuarter');
    $router->get('catalog/catalogAreas/{yqrid}', 'SubjectController@getSubjectsByYearQuarter');
    $router->get('catalog/{yqrid}/{subjectid}', 'CourseYearQuarterController@getCourseYearQuartersBySubject');
    $router->get('catalog/{yqrid}/{subjectid}/{coursenum}', 'CourseYearQuarterController@getCourseYearQuarter');
});

/*** Protected data endpoints ***/
$router->group(['prefix' => 'v1', 'middleware' => 'auth'], function () use ($router)
{  
    $router->get('employee/{username}','EmployeeController@getEmployeeByUsername');

    $router->get('student/{username}','StudentController@getStudentByUsername');
});