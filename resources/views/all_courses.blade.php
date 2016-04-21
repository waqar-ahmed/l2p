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
        <h2>All courses:</h2>
        
        <?php if ($all_courses["Status"]): ?>        
        <ol>
            <?php foreach ($all_courses["dataSet"] as $course):?>
                <li><?php echo "<a href='/course/" . $course["semester"] . "/" . 
                        $course["uniqueid"] . "'>" . $course["courseTitle"] . 
                        "</a>"?></li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
        
        
        
    </body>
</html>
