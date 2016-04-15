<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rest/auth/requestUserCode', 'AuthController@requestUserCode');
Route::get('/rest/auth/requestAccessToken', 'AuthController@requestAccessToken');
Route::resource('/rest/auth', 'AuthController');
Route::resource('/rest/course', 'CourseController');