<?php

require_once("functions.php");
require_once("php_headers.php"); // will set $conn to database

$userid = '';

if(!empty($_SESSION["userid"]))
	$userid = $_SESSION["userid"];

if(!empty($_GET["userid"]))
	$userid = $_GET["userid"];

if(empty($userid))
	exit;

unset($_SESSION["userid"]);

$ret = array();
$ret["stats"] = array();
$stats = sql_query(query_compute_stats($userid), $conn);
while($stat = sql_fetch_array($stats)) {
	$t = array();
	$t["discr"] = $stat["discr"];
	$t["reaction"] = $stat["reaction"];
	$t["t"] = $stat["t"];
	$t["f"] = $stat["f"];
	$ret["stats"][] = $t;
}
echo json_encode($ret);


//

?>