<?php



if(false){
	echo "<pre>";
	echo "This site is not available at the moment\n";
	echo "We are performing some upgrade\n";
	echo "We apologize for the inconvenience\n";
	echo "Please try again in a few minutes\n";
	echo "</pre>";
	exit;
}







header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$conn=connect_to_db("XXXXXXXXXXX");

session_start();

?>