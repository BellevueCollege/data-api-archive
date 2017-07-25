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

/*** Unprotected data endpoints ***/
$app->group(['prefix' => 'v1'], function($app)
{
    $app->post('auth/login', 'AuthController@loginPost');

    $app->get('subject','SubjectController@index');
  
    $app->get('subject/{slug}','SubjectController@getSubject');
      
    $app->get('courses/multiple', 'CourseController@getMultipleCourses');
    //$app->get('courses/{courseid}','CourseController@getCourse');
    
    $app->get('quarters/current', 'YearQuarterController@getCurrentYearQuarter');
    
    //API endpoints specific to ModoLabs requirements
    $app->get('catalog/terms', 'YearQuarterController@getViewableYearQuarters');
    $app->get('catalog/terms/{yqrid}', 'YearQuarterController@getYearQuarter');
    $app->get('catalog/catalogAreas/{yqrid}', 'SubjectController@getSubjectsByYearQuarter');
    $app->get('catalog/{yqrid}/{subjectid}', 'CourseYearQuarterController@getCourseYearQuartersBySubject');
    $app->get('catalog/{yqrid}/{subjectid}/{coursenum}', 'CourseYearQuarterController@getCourseYearQuarter');
});

/*** Protected data endpoints ***/
$app->group(['prefix' => 'v1', 'middleware' => 'auth'], function ($app)
{  
    $app->get('employee/{username}','EmployeeController@getEmployeeByUsername');

    $app->get('student/{username}','StudentController@getStudentByUsername');
});