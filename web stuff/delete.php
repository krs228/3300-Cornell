<?php
    $page = ' - Delete a Posting';//Set title of page
    $styles[] = 'styles/reset.css';
    $styles[] = 'styles/main.css';
    $styles[] = 'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css';
    $scripts[] = 'http://code.jquery.com/jquery-1.8.3.js';
    $scripts[] = 'http://code.jquery.com/ui/1.9.2/jquery-ui.js';
    include 'header.php';
    
    $error = '';
    $success = '';
    $p = isset($_POST['pid']);
    $c = isset($_POST['code']);
    if($p && $c){
	$pid= $_POST['pid'];
	$code = $_POST['code'];
	$_POST['pid'] = '';
	$_POST['code'] = '';
	
        $sql = "SELECT * FROM post WHERE pid = $pid";
        $ctl = $dbh->prepare($sql);
        $ctl->execute();
        $results = $ctl->fetch(PDO::FETCH_ASSOC);
        if (empty($results))
        {
            $error = "Invalid Book ID or Access Code"; 
        }
        $salt = $results['salt'];
        $hash = $results['hash'];
        $hashGiven = hash("sha512", $salt.$code);
        if($hashGiven == $hash){
	    $success = "Book removed.";
            $sql = "DELETE FROM post WHERE pid = $pid";
            $ctl = $dbh->prepare($sql);
            $ctl->execute();
        }else{
	    $error = "Invalid Book ID or Access Code"; 
	}
    }
?>
    <p class='blTitleB'>Delete a posting</p>
    <form action="delete.php" method="post">
	<p id="errors"><?php echo $error ?></p>
        <p id="success"><?php echo $success ?></p>
	Book ID<input type="text" name = "pid" id="pidInput"/><br />
        Access Code<input type="password" name = "code" id="acInput"/><br />
	<input type="submit" value="Add" />
    </form>
    
<?php
    include 'footer.php';
?>