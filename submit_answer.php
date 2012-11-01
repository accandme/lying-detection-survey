<?php


require_once("functions.php");
require_once("php_headers.php"); // will set $conn to database

if(empty($_SESSION["userid"])) {
	exit;
}

if(empty($_POST["pic_id"])) {
	exit;
}

if(empty($_POST["answer"])) {
	exit;
}

if(empty($_POST["time"])) {
	exit;
}

sql_query(query_insert_answer( $_SESSION["userid"],  $_POST["pic_id"],  $_POST["answer"],  $_POST["time"] ), $conn);

?>