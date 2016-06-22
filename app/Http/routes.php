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

    /*
     * Calendar
     */
    Route::get('all_course_events', 'CalendarController@viewAllCourseEvents');

    /*
     * Whats new
     */
    Route::get('whats_all_new_since/{pastMinutes}', 'WhatsNewController@whatsAllNewSince');
    Route::get('whats_all_new_since_for_semester/{sem}/{pastMinutes}', 'WhatsNewController@whatsAllNewSinceForSemester');

    Route::group(['prefix' => '/course/{cid}'], function () {

        /*
         * Announcements
         */
        Route::get('all_anouncements_count', 'AnnouncementController@viewAllAnouncementCount');
        Route::get('all_anouncements', 'AnnouncementController@viewAllAnouncements');
        Route::get('anouncement', 'AnnouncementController@viewAnouncement');
        Route::post('add_announcement', 'AnnouncementController@addAnnouncement');
        Route::post('update_announcement', 'AnnouncementController@updateAnnouncement');
        Route::get('delete_announcement/{itemId}', 'AnnouncementController@deleteAnnouncement');

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
        Route::get('delete_email/{itemId}', 'EmailController@deleteEmail');

        /*
         * Learning materials
         */
        Route::get('all_learning_materials', 'LearningMaterialController@viewAllLearningMaterials');
        Route::get('learning_material', 'LearningMaterialController@viewLearningMaterial');
        Route::get('learning_material_count', 'LearningMaterialController@viewLearningMaterialsCount');
        Route::get('delete_learning_material/{itemId}', 'LearningMaterialController@deleteLearningMaterial');

        /*
         * Calendar
         */
        Route::get('course_events', 'CalendarController@viewCourseEvents');
        Route::post('add_course_event', 'CalendarController@addCourseEvent');
        Route::post('update_course_event', 'CalendarController@updateCourseEvent');
        Route::get('delete_course_even/{itemId}', 'CalendarController@deleteCourseEvent');

        /*
         * What's new
         */
        Route::get('whats_new', 'WhatsNewController@whatsNew');
        Route::get('whats_new_since/{pastMinutes}', 'WhatsNewController@whatsNewSince');

        /*
         * Hyperlinks
         */
        Route::get('delete_hyper_link/{itemId}', 'HyperlinkController@deleteHyperlink');
        Route::get('all_hyperlink_count', 'HyperlinkController@viewAllHyperlinkCount');
        Route::get('all_hyperlinks', 'HyperlinkController@viewAllHyperlinks');
        Route::get('hyperlink', 'HyperlinkController@viewHyperlink');
        Route::post('add_hyperlink', 'HyperlinkController@addHyperlink');
        Route::post('update_hyperlink/{itemId}', 'HyperlinkController@updateHyperlink');

        /*
         * Medialibraries
         */
        Route::get('all_media_libraries', 'MediaLibraryController@viewAllMediaLibraries');
        Route::get('all_media_library_count', 'MediaLibraryController@viewAllMediaLibraryCount');
        Route::get('delete_media_library', 'MediaLibraryController@deleteMediaLibrary');
        Route::get('media_library', 'MediaLibraryController@viewMediaLibrary');


        Route::get('active_features', 'CourseController@viewActiveFeatures');
        Route::get('all_counts', 'CourseController@viewAllCounts');
        Route::get('all_courses_curr_sem', 'CourseController@viewAllCourseInfoByCurrentSemester');
        Route::get('all_discussion_item_count', 'CourseController@viewAllDiscussionItemCount');
        Route::get('all_discussion_items', 'CourseController@viewAllDiscussionItems');
        Route::get('all_discussion_root_items', 'CourseController@viewAllDiscussionRootItems');

        Route::get('all_learning_objects', 'CourseController@viewAllLearningObjects');
        Route::get('all_literatures', 'CourseController@viewAllLiteratures');
        Route::get('all_literatures_count', 'CourseController@viewAllLiteraturesCount');

        Route::get('all_shared_document_count', 'CourseController@viewAllSharedDocumentCount');
        Route::get('all_shared_documents', 'CourseController@viewAllSharedDocuments');
        Route::get('all_wiki_count', 'CourseController@viewAllWikiCount');
        Route::get('all_wikis', 'CourseController@viewAllWikis');
        Route::get('available_groups_in_group_workspace', 'CourseController@viewAvailableGroupsInGroupWorkspace');
        Route::get('course_info', 'CourseController@viewCourseInfo');
        Route::get('exam_results', 'CourseController@viewExamResults');
        Route::get('exam_results_statistics', 'CourseController@viewExamResultsStatistics');
        Route::get('grade_book', 'CourseController@viewGradeBook');

        /*
         * Download
         */
        Route::get('download_file/{fileName}/{downloadUrl}', 'L2pController@downloadFile');

        /*
         * Create folder
         */
        Route::get('createFolder/{moduleNumber}/{desiredFolderName}/{sourceDirectory}', 'L2pController@createFolder');
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

