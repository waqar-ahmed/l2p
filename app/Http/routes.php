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
Route::get('/rest/auth/verifyRequest', 'AuthController@verifyRequest');
Route::resource('/rest/auth', 'AuthController');

Route::get('/all_courses', 'CourseController@viewAllCouseInfo');
Route::get('/current_semester', 'CourseController@viewAllCourseInfoByCurrentSemester');
Route::get('/course_events_all', 'CourseController@viewAllCourseEvents');

Route::get('/course/{sem}/{cid}', 'CourseController@viewCourse');
Route::get('/course/{sem}/{cid}/all_anouncements_count', 'CourseController@viewAllAnnouncementCount');
Route::get('/course/{sem}/{cid}/all_course_events', 'CourseController@viewAllCourseEvents');
Route::get('/course/{sem}/{cid}/all_course_info_by_sem', 'CourseController@viewAllCourseInfoBySemester');
