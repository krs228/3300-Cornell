<?php
    $page = ' - Book Listing';
    $styles[] = 'styles/reset.css';
    $styles[] = 'styles/main.css';
    $styles[] = 'styles/table.css';
    $styles[] = 'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css';
    $scripts[] = 'http://code.jquery.com/jquery-1.8.3.js';
    $scripts[] = 'http://code.jquery.com/ui/1.9.2/jquery-ui.js';
    include 'header.php';

    if( !isset($_GET['bid']) ){
        include 'footer.php';
	exit;
    }
    $bid = $_GET['bid'];
    $posts = getPosts($dbh,$bid);
    $title = getBookTitle($dbh,$bid);
?>
    <p class='blTitle'>Buy Books</p>
    <span itemscope itemtype='http://schema.org/Offer'>
<?php
    if (count($posts) == 0){
        print "<p>No Books being currently sold for this course</p>\n";
	print "<table id='booktable'>";
    }
    else{
	print "<p class='blTitleB' itemprop='name'>$title</p> \n";
	print "<table id='booktable'>";
        foreach($posts as $post)
        {
            $out = array();
	    $pid = $post['pid'];
	    
            $out[] = "<td itemprop='price'>$".$post['price']."</td>";
            $out[] = "<td itemprop='description'>".$post['notes']."</td>";
            $out[] = "<td itemprop='availabilityStarts' >".$post['date']."</td>";
	    $out[] = "<td><a href='buyBook.php?pid=$pid'>Buy Now</a></td>";
            print "<tr >".join('',$out)."</tr>";
        }
    }
?>
    </table></span>
<?php
    include 'footer.php';
?>