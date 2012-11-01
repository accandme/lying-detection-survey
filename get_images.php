<?php

require_once("functions.php");
require_once("php_headers.php"); // will set $conn to database


$ret = array();
$ret["all_pics"] = array();
$images = sql_query(query_select_all_images(), $conn);
while($image = sql_fetch_array($images)) {
	$t = array();
	$t["id"] = $image["id"];
	$t["path"] = $image["path"];
	$ret["all_pics"][] = $t;
}
echo json_encode($ret);


?>