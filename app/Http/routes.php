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

Route::get('/rest/auth/requestUserCode', 'AuthController@requestUserCode');
Route::get('/rest/auth/requestAccessToken', 'AuthController@requestAccessToken');
Route::get('/rest/auth/verifyRequest', 'AuthController@verifyRequest');
Route::resource('/rest/auth', 'AuthController');

Route::get('/courses', 'CourseController@viewAllCouseInfo');
Route::get('/current_semester', 'CourseController@viewAllCourseInfoByCurrentSemester');
Route::get('/course_events_all', 'CourseController@viewAllCourseEvents');

Route::get('/course/semester/{sem}', 'CourseController@viewAllCourseInfoBySemester');
Route::get('/course/{cid}', 'CourseController@viewCourse');

Route::group(['prefix' => '/course/{cid}'], function () {
    Route::get('all_anouncements_count', 'CourseController@viewAllAnouncementCount');
    Route::get('all_course_events', 'CourseController@viewAllCourseEvents');    
    Route::get('active_features', 'CourseController@viewActiveFeatures');
    Route::get('all_anouncements', 'CourseController@viewAllAnouncements');
    Route::get('all_assignments', 'CourseController@viewAllAssignments');
    Route::get('all_counts', 'CourseController@viewAllCounts');
    Route::get('all_courses_curr_sem', 'CourseController@viewAllCourseInfoByCurrentSemester');
    Route::get('all_discussion_item_count', 'CourseController@viewAllDiscussionItemCount');
    Route::get('all_discussion_items', 'CourseController@viewAllDiscussionItems');
    Route::get('all_discussion_root_items', 'CourseController@viewAllDiscussionRootItems');
    Route::get('all_emails', 'CourseController@viewAllEmails');
    Route::get('all_hyperlinks_count', 'CourseController@viewAllHyperlinkCount');
    Route::get('all_hyperlinks', 'CourseController@viewAllHyperlinks');
    Route::get('all_learning_materials', 'CourseController@viewAllLearningMaterials');
    Route::get('all_learning_objects', 'CourseController@viewAllLearningObjects');
    Route::get('all_literatures', 'CourseController@viewAllLiteratures');
    Route::get('all_literatures_count', 'CourseController@viewAllLiteraturesCount');        
});