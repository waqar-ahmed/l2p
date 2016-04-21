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
            echo "<li><a href='/course/" . $semester . "/" . $cid . "/all_course_info_by_sem'>view all course info by semester</a></li>";
            echo "<li><a href='/course/" . $semester . "/" . $cid . "/all_anouncements_count'>view all announcement count</a></li>";
            echo "<li><a href='/course/" . $semester . "/" . $cid . "/all_course_events'>view all course events</a></li>";
        ?>
        </ol>
    </body>
</html>
