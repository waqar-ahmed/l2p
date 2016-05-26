<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Views:</h2>
        <ol>
        <?php        
            echo "<li><a href='/course/" . $cid . "/active_features'>view all active features</a></li>";
            echo "<li><a href='/course/" . $cid . "/all_anouncements_count'>view all announcement count</a></li>";
            echo "<li><a href='/course/" . $cid . "/all_anouncements'>view all announcements</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_assignments'>view all assignments</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_counts'>view all counts (not active)</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_course_events'>view all course events</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_courses_curr_sem'>view all course info by current semester</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_discussion_item_count'>view all discussion items count</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_discussion_items'>view all discussion items</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_discussion_root_items'>view all discussion root items</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_emails'>view all emails</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_hyperlinks_count'>view all hyperlinks count(not active)</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_hyperlinks'>view all hyperlinks(not active)</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_learning_materials'>view all learning materials</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_learning_objects'>view all learning objects(not active)</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_literatures'>view all literatures(not active)</a></li>";            
            echo "<li><a href='/course/" . $cid . "/all_literatures_count'>view all literatures count(not active)</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/all_media_libraries'>view all media libraries</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/all_media_library_count'>view all media library count</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/all_shared_document_count'>view all shared document count</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/all_shared_documents'>view all shared documents</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/all_wiki_count'>view all wiki count</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/all_wikis'>view all wikis</a></li>";                        
            echo "<li><a href=''>view announcement(not working, item_id needed)</a></li>";                        
            echo "<li><a href=''>view assignment(not working, item_id needed)</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/available_groups_in_group_workspace'>view all available groups</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/course_events'>view course events</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/course_info'>view course info</a></li>";                        
            echo "<li><a href=''>view discussion item(not working, item_id needed)</a></li>";                        
            echo "<li><a href=''>view email(not working, item_id needed)</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/exam_results'>view exam results(not active)</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/exam_results_statistics'>view exam results statistics(not active)</a></li>";                        
            echo "<li><a href='/course/" . $cid . "/grade_book'>view grade book(not active)</a></li>";                        
            
        ?>
        </ol>
    </body>
</html>
