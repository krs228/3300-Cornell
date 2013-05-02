<?php
    $page = ' - Sell Book';//Set title of page
    $styles[] = 'styles/reset.css';
    $styles[] = 'styles/main.css';
    $styles[] = 'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css';
    $scripts[] = 'http://code.jquery.com/jquery-1.8.3.js';
    $scripts[] = 'http://code.jquery.com/ui/1.9.2/jquery-ui.js';
    $scripts[] = 'scripts/autocomplete.js';
    include 'header.php';

    $e = isset($_POST['email']);
    $b = isset($_GET['bid']);
    $p = isset($_POST['price']);
    $n = isset($_POST['notes']);
    $error = '';
    
    if($b){
	$bid = $_GET['bid'];
        $bTitle =getBookTitle($dbh,$bid);
    }
    
    //Checks if fields are set
    if($e && $b && $p){
        //Valids Price Input
        $price = str_replace('$','',$_POST['price']);
        if(!is_numeric($price)){
            $error = $error."Invalid Price <br />";
        }elseif($price > 200 || $price < 0){
            $error = $error."Invalid Price. Must me between $0 and $200 USD. <br />";  
        }
        
        //Strips junk out of the notes field
        $notes = '';
        if(n){
            $notes = $_POST['notes'];
            if(strlen($notes) < 300){
                $notes = preg_replace('/[^a-zA-Z0-9. ]/', '', $notes);
            }else{
                $error = $error."Notes must be under 300 characters. <br />";   
            }
        }
        
        $email = $_POST['email'];
        if(!checkEmail($email)){
            $error = $error."Invalid Email <br />";
        }
        
        if($error == ''){
            $_POST['email'] = "";
            $_POST['bid'] = "";
            $_POST['price'] = "";
            
            $hD = getHash();
            $hash = $hD['hash'];
            $salt = $hD['salt'];
            $code = $hD['code'];
            $date = 'CURDATE()';
	    
	    //Inserts new posting for book
	    $pid = insertPost($dbh,$bid,$email,$price,$hash,$salt,$notes,$date);
            $success = "Submission successfully posted. Check your email for additional instructions.";     
            $message = "You have successfully posted a book on BookScore. <br />";
	    $message = $message. " It is important you do not delete this email:<br />";
            $message = $message. "'$bTitle'<br />";
            $message = $message." Unique <br />";
            $message = $message."Access Code: $code<br />";
            sendPost($email,$pid,$code);
        }
    }
?>
   <p class='blTitleB'><?php echo $bTitle;?></p>
    <form action="addBook.php?bid=<?php echo $bid;?>" method="post">
        <p id="errors"><?php echo $error ?></p>
        <p id="success"><?php echo $success ?></p>
	Email<input type="text" name = "email" id="emailInput"/>
	Price $<input type="text" name = "price" id="priceInput"/>
	<input type="submit" class="button" value="Add" /><br />
        Notes (Edition, quality, etc.)<input type="text" name="notes" id="noteInput"/><br />
    </form>
    
<?php
    include 'footer.php';
?>