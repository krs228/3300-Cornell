<?php
    //db constants
    $host = 'mysql1.000webhost.com';
    $db = 'a5727943_books';
    $user = 'a5727943_admin';
    $password = 'bears_with_beaks';
 
    // connect to db
    try {
        $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }

    function getHash(){
        // mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
        $code = getRandomString(8);
        $salt = getRandomString(32);
        $hash = hash("sha512", $salt.$code);
        //print $hash."<br />";
        //print $salt."<br />";
        //print $code."<br />";
        return array(
            "hash" => $hash,
            "salt" => $salt,
            "code" => $code,
        );
    
    }
    function getRandomString($len){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string = "";    
        for ($p = 0; $p < $len; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        return $string;
    }
    
    function getBookTitle($pdoArg,$bid){
            $sql = "SELECT title FROM book WHERE bid=$bid";
            $ctl = $pdoArg->prepare($sql);
            $ctl->execute();
            $result = $ctl->fetch(PDO::FETCH_ASSOC);
            if (empty($result))
            {
                return null;
            }
            return $result['title'];
    }
    
    function getPosts($pdoArg,$bid){
            $sql = "SELECT * FROM post WHERE bid=$bid order by price";
            $ctl = $pdoArg->prepare($sql);
            $ctl->execute();
            $result = $ctl->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result))
            {
                return null;
            }
            return $result;
    }
    
    function getPost($pdoArg,$pid){
            $sql = "SELECT email,title,p.price FROM post AS p LEFT JOIN book AS b ON p.bid = b.bid WHERE pid=$pid";
            $ctl = $pdoArg->prepare($sql);
            $ctl->execute();
            $result = $ctl->fetch(PDO::FETCH_ASSOC);
            if (empty($result))
            {
                return null;
            }
            return $result;
    }
    
    function insertPost($pdoArg,$bid,$email,$price,$hash,$salt,$notes,$date){
            $insertValues = "null,$bid,'$email',$price,'$hash','$salt','$notes',$date";
            $sql = "INSERT INTO post VALUES($insertValues)";            
            $ctl = $pdoArg->prepare($sql);
            $ctl->execute();
            $pid = $pdoArg->lastInsertId();
            return $pid;
    }
    
    
    /*Borrowed from: http://www.addedbytes.com/blog/code/email-address-validation /*/
    function checkEmail($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
             if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
                return false;
            }
        }    
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                    return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                    return false;
                }
            }
        }
        return true;
    }
    
    function sendPost($email,$pid,$code)
    {
        $message = <<<EOT
            <html>
                <body>
                <p>You have sucessfully posted a book for sale.<br />
                To remove this posting go here: <br />
                <a href='http://bookscore.net63.net/delete.php'>bookscore.net63.net/delete.php</a><br /><br />
                Then enter the following: <br />
                Book ID = $pid <br />
                Access Code = $code <br /></p>
                </body> 
            </html>
EOT;
        $headers = "Content-type: text/html\r\n"; 
        mail($email, "Alert From Bookscore", $message, $headers); 
    }
    
    
    function sendBuy($emailSeller, $emailBuyer,$pid,$title)
    {
        $message = <<<EOT
            <html>
                <body>
                <p>Somebody would like to buy your book:<br />
                $title<br />
                Their email address is: <br />
                $emailBuyer <br /><br />
                To remove this posting please refer to the previous email where: <br />
                Book ID = $pid <br />
                </body> 
            </html>
EOT;
        $headers = "Content-type: text/html\r\n"; 
        mail($emailSeller, "Alert From Bookscore", $message, $headers); 
    }
?>