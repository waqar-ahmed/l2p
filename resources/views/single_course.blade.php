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
        ?>
        </ol>
    </body>
</html>
