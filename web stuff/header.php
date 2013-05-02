<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" itemscope itemtype='http://schema.org/BookStore'>
<head>
<title>Bookscore <?php print $page ?></title>
<!--
    Eventually we need a favicon
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
-->
<?php

require "util/functions.php";

foreach($styles as $style)
{
	print "<link rel=\"stylesheet\" type=\"text/css\" href=\"$style\"/>\n";
} 
if(isset($scripts)){
	foreach($scripts as $script)
	{
		print "<script type=\"text/javascript\" src=\"$script\"></script>";
	} 
}

?>
</head>
  <body>
	<a id="headerLink" href='/'><div id="header">
		<div id="logo"><p>BookScore</p>  </div>	
	</div></a>
	<div id ="content">