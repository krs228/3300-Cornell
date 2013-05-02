<?php
require "util/functions.php";
if ( !isset($_REQUEST['term']) )
	exit;
$query = $_REQUEST['term'];

$sql = "SELECT name, term FROM course WHERE name like '$query%' LIMIT 0,15";//Fetches top 15 courses
$ctl = $dbh->prepare($sql);
$ctl->execute();
$courses = $ctl->fetchAll(PDO::FETCH_ASSOC);
$data = array();
foreach($courses as $course){
    $data[] = array(
			'label' => $course['name'] . " (" . $course['term'].")",
			'value' => $course['name'] . " " . $course['term']
		);
}


//Encoded results as json data
echo json_encode($data);
flush();
?>