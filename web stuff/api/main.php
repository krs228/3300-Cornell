<?php

$request_headers = getBestSupportedMimeType();

function returnMimeType($rh, $books){
    if(key($rh) == "application/json"){
    	returnJSON($books);
    }
    else if(key($rh) == "application/xml"){
    	returnXML($books);
    }
    else if(key($rh) == "text/csv"){
    	returnCSV($books);
    }
    else{
	//Unsupported MIME type send HTTP 406
    	header(':', true, 406);
    }
}

function courseList($rh, $courses){
    if(key($rh) == "application/json"){
    	returnJSON($courses);
    }
    else if(key($rh) == "application/xml"){
    	returnXMLCourses($courses);
    }
    else if(key($rh) == "text/csv"){
    	returnCSV($courses);
    }
    else{
	//Unsupported MIME type send HTTP 406
    	header(':', true, 406);
    }
}

function returnJSON($books) {
    header('Content-type: application/json');
    $json = json_encode($books);
    print_r($json);
}
function returnXML($books) {
    header('Content-type: application/xml');
    $xml = new SimpleXMLElement('<xml/>');
    foreach($books as $book){
	//create the root element
	$root = $xml->addChild('book');
	$root->addChild('isbn', $book['isbn']);
	$root->addChild('title', $book['title']);
	$root->addChild('author', $book['author']);
	$root->addChild('publisher', $book['publisher']);
	$root->addChild('courseName', $book['courseName']);
	$root->addChild('price', $book['price']);
    }
    print_r($xml->asXML());
}
function returnXMLCourses($courses) {
    header('Content-type: application/xml');
    $xml = new SimpleXMLElement('<xml/>');
    foreach($courses as $course){
	//create the root element
	$root = $xml->addChild('course');
	$root->addChild('name', $course['name']);
	$root->addChild('term', $course['term']);
    }
    print_r($xml->asXML());
}
function returnCSV($books) {
    $fileName = 'bookList.csv';
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$fileName}");
    //set up filehandler to output a .csv file
    $fh = @fopen( 'php://output', 'w' );
    $headerDisplayed = false;

    foreach ( $books as $book ) {
    // Add a header row if it hasn't been added yet
        if ( !$headerDisplayed ) {
            // Use the keys from $data as the titles
            fputcsv($fh, array_keys($book));
            $headerDisplayed = true;
        }
        // Put the data into the stream
        fputcsv($fh, $book);
    }
    // Close the file
    fclose($fh);
    exit;
}


//function adapted from Maciej Łebkowski
//http://stackoverflow.com/questions/1049401/how-to-select-content-type-from-http-accept-header-in-php
function getBestSupportedMimeType() {
    // Values will be stored in this array
    $AcceptTypes = Array ();

    // Accept header is case insensitive, and whitespace isn’t important
    $accept = strtolower(str_replace(' ', '', $_SERVER['HTTP_ACCEPT']));
    // divide it into parts in the place of a ","
    $accept = explode(',', $accept);
    foreach ($accept as $a) {
        // the default quality is 1.
        $q = 1;
        // check if there is a different quality
        if (strpos($a, ';q=')) {
            // divide "mime/type;q=X" into two parts: "mime/type" i "X"
            list($a, $q) = explode(';q=', $a);
        }
        // mime-type $a is accepted with the quality $q
        // WARNING: $q == 0 means, that mime-type isn’t supported!
        $AcceptTypes[$a] = $q;
    }
    arsort($AcceptTypes);

    // return the types accepted in descending order
    return $AcceptTypes;
}


?>
