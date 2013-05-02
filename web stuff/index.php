<?php
    $page = ' - Welcome';//Set title of page
    //This is how you add javascript or styles to a page
    $styles[] = 'styles/reset.css';
    $styles[] = 'styles/main.css';
    $styles[] = 'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css';
    $scripts[] = 'http://code.jquery.com/jquery-1.8.3.js';
    $scripts[] = 'http://code.jquery.com/ui/1.9.2/jquery-ui.js';
    $scripts[] = 'scripts/autocomplete.js';
    include 'header.php';
?>
    
<?php

	print("<p>BookScore is dedicated to making textbooks accessible to students.</br>
	Just type in a class name and get started!
	<p>");

?>
    
<?php
    
    
    /*
    $sql = "SELECT  * FROM course LIMIT 0,10";//Fetches top ten courses
    $ctl = $dbh->prepare($sql);
    $ctl->execute();
    $courses = $ctl->fetchAll(PDO::FETCH_ASSOC);//fetch single $courses = $ctl->fetch(PDO::FETCH_ASSOC);
    foreach($courses as $course)
    {
        $name = $course['name'];
        $term = $course['term'];
        $instructor = $course['instructor'];
        $lineOut = "<p>$name  $term  $instructor</p>";
        print $lineOut;
    }
    */
?>
    <form action="displayCourse.php" method="GET">
	Please Select A Course
	<input type="text" id="courseSearch" name = "courseSearch" />
	<input type="submit" value="Find Books" class="button"/>
    </form>
    
<?php
	print("<img src=\"../images/clockTower.jpg\" />");
?>
    
<?php
    include 'footer.php';
?>