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

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);


Route::get('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/authenticate', 'AuthController@authenticateUser');

Route::group(['middleware'=>'l2pApi'], function() {        

    Route::get('/semesters', 'CourseController@viewAllSemesters');
    Route::get('/courses', 'CourseController@viewAllCouseInfo');
    Route::get('/current_semester', 'CourseController@viewAllCourseInfoByCurrentSemester');
    Route::get('/course/semester/{sem}', 'CourseController@viewAllCourseInfoBySemester');
    Route::get('/course/{cid}', 'CourseController@viewCourse');
    
    Route::get('/view_user_role/{cid}', 'L2pController@viewUserRole');
    
    Route::get('all_course_events', 'CourseController@viewAllCourseEvents');    

    Route::group(['prefix' => '/course/{cid}'], function () {
        
        /*
         * Announcements
         */
        Route::get('all_anouncements_count', 'AnnouncementController@viewAllAnouncementCount');
        Route::get('all_anouncements', 'AnnouncementController@viewAllAnouncements');
        Route::post('add_announcement', 'AnnouncementController@addAnnouncement');
        
        /*
         * Assignments
         */
        Route::get('all_assignments', 'AssignmentController@viewAllAssignments');
        Route::get('assignment/{itemId}', 'AssignmentController@viewAssignments');        
        Route::get('add_assignment', 'AssignmentController@addAssignment');
        Route::get('delete_assignment/{itemId}', 'AssignmentController@deleteAssignment');
        Route::post('provide_assignment_solution/{assignmentId}/{gwsNameAlias}');
        Route::get('delete_assignment_solution/{itemId}');
        
        /*
         * Emails
         */
        Route::get('all_emails', 'EmailController@viewAllEmails');
        Route::get('email/{itemId}', 'EmailController@viewEmail');        
        Route::post('add_email', 'EmailController@addEmail');  
        
        /*
         * Learning materials
         */
        Route::get('all_learning_materials', 'LearningMaterialController@viewAllLearningMaterials');
        
        
        Route::get('active_features', 'CourseController@viewActiveFeatures');                
        Route::get('all_counts', 'CourseController@viewAllCounts');
        Route::get('all_courses_curr_sem', 'CourseController@viewAllCourseInfoByCurrentSemester');
        Route::get('all_discussion_item_count', 'CourseController@viewAllDiscussionItemCount');
        Route::get('all_discussion_items', 'CourseController@viewAllDiscussionItems');
        Route::get('all_discussion_root_items', 'CourseController@viewAllDiscussionRootItems');               
        
        Route::get('all_hyperlinks_count', 'CourseController@viewAllHyperlinkCount');
        Route::get('all_hyperlinks', 'CourseController@viewAllHyperlinks');
        
        Route::get('all_learning_objects', 'CourseController@viewAllLearningObjects');
        Route::get('all_literatures', 'CourseController@viewAllLiteratures');
        Route::get('all_literatures_count', 'CourseController@viewAllLiteraturesCount');        
        Route::get('all_media_libraries', 'CourseController@viewAllMediaLibraries');        
        Route::get('all_media_library_count', 'CourseController@viewAllMediaLibraryCount');        
        Route::get('all_shared_document_count', 'CourseController@viewAllSharedDocumentCount');        
        Route::get('all_shared_documents', 'CourseController@viewAllSharedDocuments');        
        Route::get('all_wiki_count', 'CourseController@viewAllWikiCount');        
        Route::get('all_wikis', 'CourseController@viewAllWikis');        
        Route::get('available_groups_in_group_workspace', 'CourseController@viewAvailableGroupsInGroupWorkspace');        
        Route::get('course_events', 'CourseController@viewCourseEvents');        
        Route::get('course_info', 'CourseController@viewCourseInfo');        
        Route::get('exam_results', 'CourseController@viewExamResults');        
        Route::get('exam_results_statistics', 'CourseController@viewExamResultsStatistics');        
        Route::get('grade_book', 'CourseController@viewGradeBook');                 
        
        /*
         * Download
         */
        Route::get('download_file/{fileName}/{downloadUrl}', 'L2pController@downloadFile');                 
        
    }); 
    
    /*
     * Emails
     */    
    Route::get('inbox', 'EmailController@inbox');                    
    
    /*
     * Routes used for backend
     */
    Route::get('/_courses', 'CourseController@_viewAllCourseInfo');
        
});    

