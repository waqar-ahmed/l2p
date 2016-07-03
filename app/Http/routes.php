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
    /*
     * Semester
     */
    Route::get('/semesters', 'SemesterController@viewAllSemesters');
    Route::get('/current_semester', 'CourseController@viewAllCourseInfoByCurrentSemester');
    Route::get('/course/semester/{sem}', 'CourseController@viewAllCourseInfoBySemester');
<<<<<<< HEAD
    Route::get('/course/{cid}', 'CourseController@viewCourse');

    Route::get('/view_user_role/{cid}', 'L2pController@viewUserRole');

=======
    
    Route::get('/courses', 'CourseController@viewAllCouseInfo');           
    
>>>>>>> master
    /*
     * Calendar
     */
    Route::get('all_course_events', 'CalendarController@viewAllCourseEvents');

    /*
     * Whats new
     */
<<<<<<< HEAD
    Route::get('whats_all_new_since/{pastMinutes}', 'WhatsNewController@whatsAllNewSince');
    Route::get('whats_all_new_since_for_semester/{sem}/{pastMinutes}', 'WhatsNewController@whatsAllNewSinceForSemester');

    Route::group(['prefix' => '/course/{cid}'], function () {

=======
    Route::get('whats_all_new_since/{pastMinutes}', 'WhatsNewController@whatsAllNewSince');  
    Route::get('whats_all_new_since_for_semester/{sem}/{pastMinutes}', 'WhatsNewController@whatsAllNewSinceForSemester');  
    Route::get('whats_all_new_since_new/{pastMinutes}', 'WhatsNewController@whatsNewLearningMaterial');  

    Route::group(['prefix' => '/course/{cid}'], function () {        
        
>>>>>>> master
        /*
         * Announcements
         */
        Route::get('all_announcements_count', 'AnnouncementController@viewAllAnnouncementCount');
        Route::get('all_announcements', 'AnnouncementController@viewAllAnnouncements');
        Route::get('announcement/{itemId}', 'AnnouncementController@viewAnnouncement');
        Route::post('add_announcement', 'AnnouncementController@addAnnouncement');
        Route::post('update_announcement/{itemId}', 'AnnouncementController@updateAnnouncement');
        Route::post('upload_in_announcement', 'AnnouncementController@uploadInAnnouncement');
        Route::get('delete_announcement/{itemId}', 'AnnouncementController@deleteAnnouncement');

        /*
         * Assignments
         */
        Route::get('all_assignments', 'AssignmentController@viewAllAssignments');
<<<<<<< HEAD
        Route::get('assignment/{itemId}', 'AssignmentController@viewAssignments');
        Route::get('add_assignment', 'AssignmentController@addAssignment');
        Route::get('delete_assignment/{itemId}', 'AssignmentController@deleteAssignment');
        Route::post('provide_assignment_solution/{assignmentId}/{gwsNameAlias}');
        Route::get('delete_assignment_solution/{itemId}');

=======
        Route::get('assignment/{itemId}', 'AssignmentController@viewAssignment');        
        Route::post('add_assignment', 'AssignmentController@addAssignment');
        Route::get('delete_assignment/{itemId}', 'AssignmentController@deleteAssignment');
        Route::post('provide_assignment_solution/{assignmentId}/{gwsNameAlias}', 'AssignmentController@provideAssignmentSolution');
        Route::post('upload_in_assignment', 'AssignmentController@uploadInAssignment');
        Route::get('delete_assignment_solution/{itemId}', 'AssignmentController@deleteAssignmentSolution');
        
>>>>>>> master
        /*
         * Emails
         */
        Route::get('all_emails', 'EmailController@viewAllEmails');
<<<<<<< HEAD
        Route::get('email/{itemId}', 'EmailController@viewEmail');
        Route::post('add_email', 'EmailController@addEmail');
        Route::get('delete_email/{itemId}', 'EmailController@deleteEmail');

=======
        Route::get('email/{itemId}', 'EmailController@viewEmail');        
        Route::post('add_email', 'EmailController@addEmail');  
        Route::get('delete_email/{itemId}', 'EmailController@deleteEmail');  
        Route::post('upload_in_email', 'EmailController@uploadInEmail');
        
>>>>>>> master
        /*
         * Learning materials
         */
        Route::get('all_learning_materials', 'LearningMaterialController@viewAllLearningMaterials');
        Route::get('learning_material/{itemId}', 'LearningMaterialController@viewLearningMaterial');
        Route::get('learning_material_count', 'LearningMaterialController@viewLearningMaterialsCount');
        Route::get('delete_learning_material/{itemId}', 'LearningMaterialController@deleteLearningMaterial');
<<<<<<< HEAD

        /*
         * Calendar
         */
        Route::get('course_events', 'CalendarController@viewCourseEvents');
        Route::post('add_course_event', 'CalendarController@addCourseEvent');
        Route::post('update_course_event', 'CalendarController@updateCourseEvent');
        Route::get('delete_course_even/{itemId}', 'CalendarController@deleteCourseEvent');

=======
        Route::post('upload_in_learning_material', 'LearningMaterialController@uploadInLearningMaterial');
        
        /*
         * Calendar
         */
        Route::get('course_events', 'CalendarController@viewCourseEvents');  
        Route::post('add_course_event', 'CalendarController@addCourseEvent');  
        Route::post('update_course_event/{itemId}', 'CalendarController@updateCourseEvent');  
        Route::get('delete_course_event/{itemId}', 'CalendarController@deleteCourseEvent');  
        
>>>>>>> master
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
        Route::get('hyperlink/{itemId}', 'HyperlinkController@viewHyperlink');
        Route::post('add_hyperlink', 'HyperlinkController@addHyperlink');
        Route::post('update_hyperlink/{itemId}', 'HyperlinkController@updateHyperlink');

        /*
         * Media libraries
         */
        Route::get('all_media_libraries', 'MediaLibraryController@viewAllMediaLibraries');
        Route::get('all_media_library_count', 'MediaLibraryController@viewAllMediaLibraryCount');
        Route::get('delete_media_library/{itemId}', 'MediaLibraryController@deleteMediaLibrary');
        Route::get('media_library/{itemId}', 'MediaLibraryController@viewMediaLibrary');
        Route::post('upload_in_media_library', 'MediaLibraryController@uploadInMediaLibrary');

        /*
         * Discussion
         */
        Route::get('all_discussion_item_count', 'DiscussionController@viewAllDiscussionItemCount');
        Route::get('all_discussion_items', 'DiscussionController@viewAllDiscussionItems');
<<<<<<< HEAD
        Route::get('all_discussion_root_items', 'DiscussionController@viewAllDiscussionRootItems');
        Route::post('add_discussion_thread', 'DiscussionController@addDiscussionThread');
        Route::post('add_discussion_thread_reply/{replyToId}', 'DiscussionController@addDiscussionThreadReply');
        Route::post('update_discussion_thread/{selfId}', 'DiscussionController@updateDiscussionThread');
        Route::post('update_discussion_thread_reply/{selfId}', 'DiscussionController@updateDiscussionThreadReply');
        Route::get('delete_discussion_item/{selfId}', 'DiscussionController@deleteDiscussionItem');

        Route::get('active_features', 'CourseController@viewActiveFeatures');
        Route::get('all_counts', 'CourseController@viewAllCounts');
        Route::get('all_courses_curr_sem', 'CourseController@viewAllCourseInfoByCurrentSemester');

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

=======
        Route::get('all_discussion_root_items', 'DiscussionController@viewAllDiscussionRootItems');                              
        Route::post('add_discussion_thread', 'DiscussionController@addDiscussionThread');                              
        Route::post('add_discussion_thread_reply/{replyToId}', 'DiscussionController@addDiscussionThreadReply');                              
        Route::post('update_discussion_thread/{selfId}', 'DiscussionController@updateDiscussionThread');                              
        Route::post('update_discussion_thread_reply/{selfId}', 'DiscussionController@updateDiscussionThreadReply');                              
        Route::get('delete_discussion_item/{selfId}', 'DiscussionController@deleteDiscussionItem');                                      
        Route::get('discussion_item/{itemId}', 'DiscussionController@viewDiscussion');                                      
        
        /*
         * Courses
         */        
        Route::get('course_info', 'CourseController@viewCourseInfo');                                                
        
        /*
         * Literatures
         */
        Route::get('all_literatures', 'LiteratureController@viewAllLiteratures');
        Route::get('all_literatures_count', 'LiteratureController@viewAllLiteraturesCount');        
        Route::get('literature/{itemId}', 'LiteratureController@viewLiterature');        
        Route::post('add_literature', 'LiteratureController@addLiterature');        
        Route::get('delete_literature/{itemId}', 'LiteratureController@deleteLiterature');        
        Route::post('update_literature/{itemId}', 'LiteratureController@updateLiterature');        
        
        
>>>>>>> master
        /*
         * Shared documents
         */        
        Route::get('all_shared_documents_count', 'SharedDocsController@viewAllSharedDocumentCount');        
        Route::get('all_shared_documents', 'SharedDocsController@viewAllSharedDocuments');        
        Route::get('delete_shared_document/{itemId}', 'SharedDocsController@deleteSharedDocument');        
        Route::post('upload_in_shared_document', 'SharedDocsController@uploadInSharedDocument');        
        
        /*
         * Wiki
         */
<<<<<<< HEAD
        Route::get('download_file/{fileName}/{downloadUrl}', 'L2pController@downloadFile');

=======
        Route::get('all_wiki_count', 'WikiController@viewAllWikiCount');        
        Route::get('all_wikis', 'WikiController@viewAllWikis'); 
        Route::get('wiki/{itemId}', 'WikiController@viewWiki'); 
        Route::get('wiki_version/{itemId}/{versionId}', 'WikiController@viewWikiVersion'); 
        Route::post('add_wiki', 'WikiController@addWiki'); 
        Route::post('update_wiki/{itemId}', 'WikiController@updateWiki'); 
        Route::get('delete_wiki/{itemId}', 'WikiController@deleteWiki'); 
        
>>>>>>> master
        /*
         * Others
         */
<<<<<<< HEAD
        Route::get('createFolder/{moduleNumber}/{desiredFolderName}/{sourceDirectory}', 'L2pController@createFolder');
    });

=======
        Route::get('view_user_role', 'L2pController@viewUserRole');
        Route::get('active_features', 'L2pController@viewActiveFeatures');
        Route::get('all_counts', 'L2pController@viewAllCounts');    
        
        Route::get('available_groups_in_group_workspace', 'L2pController@viewAvailableGroupsInGroupWorkspace');                              
        Route::get('my_group_workspace', 'L2pController@viewMyGroupWorkspace');                              
        Route::get('exam_results', 'L2pController@viewExamResults');        
        Route::get('exam_results_statistics', 'L2pController@viewExamResultsStatistics');        
        Route::get('grade_book', 'L2pController@viewGradeBook');                                 
        Route::get('download_file/{fileName}/{downloadUrl}', 'L2pController@downloadFile');                        
        Route::post('createFolder', 'L2pController@createFolder');        
    }); 
    
>>>>>>> master
    /*
     * Emails
     */
    Route::get('inbox', 'EmailController@inbox');

    /*
     * Routes used for backend
     */
    Route::get('/_courses', 'CourseController@_viewAllCourseInfo');

    Route::get('/_course/{cid}', 'CourseController@_viewCourse');
    Route::post('/_semesters', 'L2pController@_sortSemesters');
    Route::get('/_tester', 'L2pController@_viewTesterPage');
});

