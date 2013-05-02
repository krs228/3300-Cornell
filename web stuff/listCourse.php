<?php
    include 'api/main.php';
    $bot = $_SERVER['HTTP_USER_AGENT'];
    if($bot == 'Googlebot' || $bot == 'Googlebot-richsnippets'){
    //Added so google can view microdata and so they can't use our api

    }elseif(!(key($request_headers) == 'text/html')){
      //if requested content other than HTML

	include 'util/functions.php';

	$sql = "SELECT name, term FROM course order by name";
        $ctl = $dbh->prepare($sql);
        $ctl->execute();
        $courses = $ctl->fetchAll(PDO::FETCH_ASSOC);
        $mD ="itemscope itemtype='http://schema.org/Book'";

    	courseList($request_headers, $courses);
    	exit;
    }
    $page = ' - Course Listing';
    $styles[] = 'styles/reset.css';
    $styles[] = 'styles/main.css';
    $styles[] = 'styles/table.css';
    $styles[] = 'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css';
    $scripts[] = 'http://code.jquery.com/jquery-1.8.3.js';
    $scripts[] = 'http://code.jquery.com/ui/1.9.2/jquery-ui.js';
    $scripts[] = 'scripts/autocomplete.js';
    include 'header.php';
    $sql = "SELECT name, term FROM course order by name";
    $ctl = $dbh->prepare($sql);
    $ctl->execute();
    $courses = $ctl->fetchAll(PDO::FETCH_ASSOC);
    $mD ="itemscope itemtype='http://schema.org/Book'";
    print "<table id='booktable'> \n";
    if (count($courses) == 0){
        print "<p>No Courses listed</p>";
    }
    else{

	print "<p class='blTitleB'>Courses Offered</p>";
	$list = array();
        foreach($courses as $course)
        {
	    if(!in_array($course['name'],$list)){
		$list[] = $course['name'];
		$out = array();
                //$out[] = "<td itemprop='courseName'>".$course['courseName']."</td>";
		$out[] = "<td itemprop='courseName'><a href='displayCourse.php?courseSearch=".$course['name']."+".$course['term']."'>".$course['name']."</a></td>";
                print "<tr $mD>".join('',$out)."</tr>";
	    }
        }
    }
?>
    </table>
<?php
    include 'footer.php';
?>
