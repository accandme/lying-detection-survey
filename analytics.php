<?php

require_once("functions.php");
require_once("php_headers.php"); // will set $conn to database





if(!empty($_GET["dataformat"])) {
	$dataformat = $_GET["dataformat"];
	$ret = array();
	/*$ret["stats"] = array();
	$stats = sql_query(query_compute_stats($userid), $conn);
	while($stat = sql_fetch_array($stats)) {
		$t = array();
		$t["discr"] = $stat["discr"];
		$t["reaction"] = $stat["reaction"];
		$t["t"] = $stat["t"];
		$t["f"] = $stat["f"];
		$ret["stats"][] = $t;
	}*/
	if(!empty($_GET["q"])) {
		$sanitized_q = $_GET["q"];
		$sanitized_q = str_ireplace("ALTER", "", $sanitized_q);
		$sanitized_q = str_ireplace("CREATE", "", $sanitized_q);
		$sanitized_q = str_ireplace("DELETE", "", $sanitized_q);
		$sanitized_q = str_ireplace("DROP", "", $sanitized_q);
		$sanitized_q = str_ireplace("EXECUTE", "", $sanitized_q);
		$sanitized_q = str_ireplace("INDEX", "", $sanitized_q);
		$sanitized_q = str_ireplace("INSERT", "", $sanitized_q);
		$sanitized_q = str_ireplace("LOCK", "", $sanitized_q);
		$sanitized_q = str_ireplace("REFERENCES", "", $sanitized_q);
		$sanitized_q = str_ireplace("UPDATE", "", $sanitized_q);
		if($dataformat == 2) {
			header("Pragma: public"); // required 
			header("Expires: 0"); 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
			header("Cache-Control: private",false); // required for certain browsers 
			header("Content-Type: application/force-download"); 
			header("Content-Disposition: attachment; filename=\"data.csv\";" ); 
			header("Content-Transfer-Encoding: binary"); 
		}
		$qrs = sql_query($sanitized_q, $conn);
		if($dataformat == 1) echo "/*" . mysql_error($conn) . "*/";
		$count = sql_num_fields($qrs);
		$hdrs = array();
		for($i = 0; $i < $count; $i++) {
			$obj = sql_fetch_field($qrs, $i);
			$hdrs[] = $obj->name;
			if($dataformat == 2) echo $obj->name . ",";
		}
		if($dataformat == 2) echo "\n";
		$ret[] = $hdrs;
		while($qr = sql_fetch_array($qrs)) {
			$cnt = array();
			for($i = 0; $i < $count; $i++) {
				$t_cnt = doubleval($qr[$hdrs[$i]]);
				$cnt[] = $t_cnt;
				if($dataformat == 2) echo "$t_cnt,";
			}
			$ret[] = $cnt;
			if($dataformat == 2) echo "\n";
		}
	}
	if($dataformat == 1) echo json_encode($ret);
	exit;
}
/*
if(!empty($_GET["byimage"])) {

	$stats = sql_query(query_select_stats_by_image_category_filtered(empty($_GET["filter"]) ? "" : $_GET["filter"]), $conn);
	$table = array();
	$last_t = "";
	while($stat = sql_fetch_array($stats)) {
		if($last_t != $stat["t"]) {
			$last_t = $stat["t"];
			$table[$last_t] = array();
		}
		$table[$last_t][$stat["f"]] = array();
		$table[$last_t][$stat["f"]]["lying"] = $stat["lying"];
		$table[$last_t][$stat["f"]]["nlying"] = $stat["nlying"];
		$table[$last_t][$stat["f"]]["reaction"] = $stat["reaction"];
	}
	$stats_html = "<table border=1 align=center style='margin-top:50px;'>";
	$stats_html .= "<tr>";
	$stats_html .= "<td><b></b></td>";
	for($i = 0; $i < 5; $i++) {
		$stats_html .= "<td style='width:200px;height:30px;text-align:center;vertical-align:middle;'><b>f$i</b></td>";
	}
	$stats_html .= "</tr>";
	for($i = 0; $i < 5; $i++) {
		$stats_html .= "<tr>";
		$stats_html .= "<td style='width:30px;height:100px;text-align:center;vertical-align:middle;'><b>t$i</b></td>";
		for($j = 0; $j < 5; $j++) {
			$stats_html .= "<td style='width:200px;height:100px;text-align:center;vertical-align:middle;'><div style='position:relative;width:200px;height:100px;overflow:hidden;'>";
			$stats_html .= "<div id='pie_chart_div_$i$j' style='position:absolute;top:-40px;left:-45px;width: 250px; height: 180px;'></div>";
			$stats_html .= "<div id='gauge_chart_div_$i$j' style='position:absolute;top:0px;left:100px;width: 105px; height: 105px;'></div>";
			$stats_html .= "</div></td>";
			$stats_html .= "<script type='text/javascript'>";
			$stats_html .= "google.setOnLoadCallback(function () { ";
			$stats_html .= "var data = new google.visualization.DataTable(); data.addColumn('string', 'resp'); data.addColumn('number', 'votes');  data.addRows([ ['not lying',    {$table[$i][$j]["nlying"]}], ['lying',    {$table[$i][$j]["lying"]}] ]);  ";
			$stats_html .= "var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div_$i$j')); chart.draw(data, {  }); ";
			$stats_html .= "} ); ";
			$stats_html .= "google.setOnLoadCallback(function () { ";
			$stats_html .= "var data = new google.visualization.DataTable(); data.addColumn('string', 'Label'); data.addColumn('number', 'Value'); data.addRows([ ['Reactivity', {$table[$i][$j]["reaction"]}] ]);";
			$stats_html .= "var chart = new google.visualization.Gauge(document.getElementById('gauge_chart_div_$i$j')); chart.draw(data, { redFrom: 90, redTo: 100, yellowFrom:75, yellowTo: 90, minorTicks: 5 });";
			$stats_html .= "} ); ";
			$stats_html .= "</script>";
		}
		$stats_html .= "</tr>";
	}
	$stats_html .= "</table>";

} else {

	$stats_html = "<table border=0 align=center>";
	$stats_html .= "<form action='?' method=get>";
	$stats_html .= "<tr>";
	$stats_html .= "<td><b></b></td>";
	$stats_html .= "<td style='width:180px;text-align:center'><b>timestamp</b><br><span style='font-size:8pt;'>$>'2012-04-14 00:00:00'</span><br><input size=18 name=t value='".(empty($_GET["t"]) ? "" : htmlentities($_GET["t"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='width:60px;text-align:center'><b>sex</b><br><span style='font-size:8pt;'>$='M'</span><br><input size=6 name=s value='".(empty($_GET["s"]) ? "" : htmlentities($_GET["s"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='width:60px;text-align:center'><b>age</b><br><span style='font-size:8pt;'>$=17</span><br><input size=6 name=a value='".(empty($_GET["a"]) ? "" : htmlentities($_GET["a"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='width:60px;text-align:center'><b>educ</b><br><span style='font-size:8pt;'>$=13</span><br><input size=6 name=e value='".(empty($_GET["e"]) ? "" : htmlentities($_GET["e"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='width:120px;text-align:center'><b>ocountry</b><br><span style='font-size:8pt;'>$='Lebanon'</span><br><input size=12 name=o value='".(empty($_GET["o"]) ? "" : htmlentities($_GET["o"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='width:120px;text-align:center'><b>rcountry</b><br><span style='font-size:8pt;'>$='Lebanon'</span><br><input size=12 name=r value='".(empty($_GET["r"]) ? "" : htmlentities($_GET["r"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='width:60px;text-align:center'><b>prog</b><br><span style='font-size:8pt;'>$>50</span><br><input size=6 name=p value='".(empty($_GET["p"]) ? "" : htmlentities($_GET["p"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='width:60px;text-align:center'><b>consist</b><br><span style='font-size:8pt;'>$<95</span><br><input size=6 name=c value='".(empty($_GET["c"]) ? "" : htmlentities($_GET["c"], ENT_QUOTES))."'></td>";
	$stats_html .= "<td style='text-align:center'><b>&nbsp;</b><br><span style='font-size:8pt;'>&nbsp;</span><br><input type=submit value='...'></td>";
	$stats_html .= "</tr>";
	$stats_html .= "</form>";
	$i = 0;
	//$stats = sql_query(query_select_all_stats(), $conn);
	$stats = sql_query(query_select_all_stats_with_filter_arr($_GET), $conn);
	$fids = array();
	while($stat = sql_fetch_array($stats)) {
		$i++;
		$fids[] = $stat["id"];
		$stats_html .= "<tr>";
		$stats_html .= "<td style='text-align:center'>$i.</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["timestamp"]}</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["sex"]}</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["age"]}</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["education"]}</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["ocountry"]}</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["rcountry"]}</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["progress"]}%</td>";
		$stats_html .= "<td style='text-align:center'>{$stat["consistency"]}%</td>";
		$stats_html .= "<td><button onclick='show_stats_of({$stat["id"]})'>...</button></td>";
		$stats_html .= "</tr>";
	}
	$stats_html .= "</table>";
	$fids = implode(",", $fids);
	$stats_html .= "<div style='margin:auto;text-align:center;'><a href='?byimage=1&filter=$fids'>show detailed stats</a></div>";

}


*/




/*

USER-AVGTIME
============

SELECT u.id, AVG( a.reaction ) AS reaction
FROM answers a, images i, users u
WHERE i.id = a.imageid
AND u.id = a.userid
AND u.phase IS NULL 
GROUP BY u.id


IMAGE-AVGTIME (phase 3)
=============
select a.imageid as imageid, avg(ln(a.reaction / uat.avg_usr_reac)) as avg_pic_reac
from answers a,
(
select u.id as userid, avg(a.reaction) as avg_usr_reac
from answers a, images i, users u
where i.id = a.imageid AND u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid
group by a.imageid

IMAGE-DISC(phase 2)
====================
select imageid, 1 / ln((case when t > f then t else f end) / (case when t > f then f else t end)) as ratio
from (
select a.imageid as imageid, sum(case when a.result = 't' then 1 else 0 end) as t, sum(case when a.result = 'f' then 1 else 0 end) as f
from answers a, users u
where a.userid = u.id
and u.phase is not null
group by a.imageid
) img_stat


*/


?><html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SHS Survey :: Lying Detection</title>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    

<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
//google.load('visualization', '1', {packages:['gauge']});
//google.setOnLoadCallback(drawChart);

function sendRequest(url,callback,postData) {
	var req = createXMLHTTPObject();
	if (!req) return;
	var method = (postData) ? "POST" : "GET";
	req.open(method,url,true);
	req.setRequestHeader('User-Agent','XMLHTTP/1.0');
	if (postData)
		req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	req.onreadystatechange = function () {
		if (req.readyState != 4) return;
		/*if (req.status != 200 && req.status != 304) {
//			alert('HTTP error ' + req.status);
			return; // TODO if this happens we're stuck
		}*/
		callback(req);
	}
	if (req.readyState == 4) return;
	req.send(postData);
}

var XMLHttpFactories = [
	function () {return new XMLHttpRequest()},
	function () {return new ActiveXObject("Msxml2.XMLHTTP")},
	function () {return new ActiveXObject("Msxml3.XMLHTTP")},
	function () {return new ActiveXObject("Microsoft.XMLHTTP")}
];

function createXMLHTTPObject() {
	var xmlhttp = false;
	for (var i=0;i<XMLHttpFactories.length;i++) {
		try {
			xmlhttp = XMLHttpFactories[i]();
		}
		catch (e) {
			continue;
		}
		break;
	}
	return xmlhttp;
}

</script>

</head>






<body style="text-align:center">




<div style='display:none;'>

<textarea id=taquery1>
/*reaction time (from phase 3) as a function of randomness (from phase 2) - by image*/
select ratio, avg_pic_reac
from (

select a.imageid as imageid, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, images i, users u
where i.id = a.imageid AND u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid
group by a.imageid

) img_react,
(

select imageid, (case when t > f then f else t end) / (case when t > f then t else f end) as ratio
from (
select a.imageid as imageid, sum(case when a.result = 't' then 1 else 0 end) as t, sum(case when a.result = 'f' then 1 else 0 end) as f
from answers a, users u
where a.userid = u.id
and u.phase is not null
group by a.imageid
) img_stat

) img_discr
where img_react.imageid = img_discr.imageid
order by ratio
</textarea>

<textarea id=taquery2>
/*reaction time (from phase 3) as a function of randomness (from phase 2) - by image category*/
select ratio, avg_pic_reac
from (

select i.t as t, i.f as f, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a, images i,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, images i, users u
where i.id = a.imageid AND u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid and a.imageid = i.id
group by i.t, i.f

) img_react,
(

select t, f, (case when tt > ff then ff else tt end) / (case when tt > ff then tt else ff end) as ratio
from (
select i.t as t, i.f as f, sum(case when a.result = 't' then 1 else 0 end) as tt, sum(case when a.result = 'f' then 1 else 0 end) as ff
from answers a, users u, images i
where a.userid = u.id and a.imageid = i.id
and u.phase is not null
group by i.t, i.f
) img_stat

) img_discr
where img_react.t = img_discr.t and img_react.f = img_discr.f
order by ratio
</textarea>

<textarea id=taquery3>
/*reaction time (from phase 3) as a function of randomness (from phase 2) - by number of F cues*/
select ratio, avg_pic_reac
from (

select i.f as f, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a, images i,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, images i, users u
where i.id = a.imageid AND u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid and a.imageid = i.id
group by i.f

) img_react,
(

select f, (case when tt > ff then ff else tt end) / (case when tt > ff then tt else ff end) as ratio
from (
select i.f as f, sum(case when a.result = 't' then 1 else 0 end) as tt, sum(case when a.result = 'f' then 1 else 0 end) as ff
from answers a, users u, images i
where a.userid = u.id and a.imageid = i.id
and u.phase is not null
group by i.f
) img_stat

) img_discr
where img_react.f = img_discr.f
order by ratio
</textarea>

<textarea id=taquery4>
/* displays randomness of ppl responses as a function of increasing T cues and as a function of increasing F cues in pictures ; in phase 2 */
select tbl_t.t as x, tbl_t.ratio as t, tbl_f.ratio as f
from
(
select t, (case when tt > ff then ff else tt end) / (case when tt > ff then tt else ff end) as ratio
from (
select i.t as t, sum(case when a.result = 't' then 1 else 0 end) as tt, sum(case when a.result = 'f' then 1 else 0 end) as ff
from answers a, users u, images i
where a.userid = u.id and a.imageid = i.id
and u.phase is not null
group by i.t
) img_stat
) tbl_t,

(
select f, (case when tt > ff then ff else tt end) / (case when tt > ff then tt else ff end) as ratio
from (
select i.f as f, sum(case when a.result = 't' then 1 else 0 end) as tt, sum(case when a.result = 'f' then 1 else 0 end) as ff
from answers a, users u, images i
where a.userid = u.id and a.imageid = i.id
and u.phase is not null
group by i.f
) img_stat
) tbl_f
where tbl_f.f = tbl_t.t
</textarea>

<textarea id=taquery5>
/* displays reaction time of ppl as a function of increasing T cues and as a function of increasing F cues in pictures ; in phase 3 */
select tbl_t.t as x, tbl_t.avg_pic_reac as t, tbl_f.avg_pic_reac as f
from
(
select i.t as t, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a, images i,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, images i, users u
where i.id = a.imageid AND u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid and a.imageid = i.id
group by i.t
) tbl_t,

(
select i.f as f, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a, images i,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, images i, users u
where i.id = a.imageid AND u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid and a.imageid = i.id
group by i.f
) tbl_f
where tbl_f.f = tbl_t.t
</textarea>

<textarea id=taquery6>
/*reaction time (from phase 3) as a function of randomness (from phase 2) - by quartiles of image on the randomness scale */
select ratio, avg(avg_pic_reac) as avg_pic_reac
from (

select a.imageid as imageid, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, users u
where u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid
group by a.imageid

) img_react,
(

select imageid, case when ratio < 0.25 then 1 when ratio < 0.5 then 2 when ratio < 0.75 then 3 else 4 end as ratio
from (
select imageid, (case when t > f then f else t end) / (case when t > f then t else f end) as ratio
from (
select a.imageid as imageid, sum(case when a.result = 't' then 1 else 0 end) as t, sum(case when a.result = 'f' then 1 else 0 end) as f
from answers a, users u
where a.userid = u.id
and u.phase is not null
group by a.imageid
) img_stat
) img_stat_categ

) img_discr
where img_react.imageid = img_discr.imageid
group by ratio
</textarea>

<textarea id=taquery7>
/*real consistency based on the quartiles of randomness of images*/
select userid, (case when categ_1 < categ_2 then 1 else 0 end) + (case when categ_2 < categ_3 then 1 else 0 end) + (case when categ_3 < categ_4 then 1 else 0 end) as consistency
from (
select userid, sum(case when ratio_categ = 1 then avg_time else 0 end) as categ_1, sum(case when ratio_categ = 2 then avg_time else 0 end) as categ_2, sum(case when ratio_categ = 3 then avg_time else 0 end) as categ_3, sum(case when ratio_categ = 4 then avg_time else 0 end) as categ_4
from(
select userid, ratio_categ, avg(avg_pic_reac) as avg_time
from (

select a.userid as userid, a.imageid as imageid, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, users u
where u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid
group by a.imageid, a.userid

) img_react,
(

select imageid, case when ratio < 0.25 then 1 when ratio < 0.5 then 2 when ratio < 0.75 then 3 else 4 end as ratio_categ
from (
select imageid, (case when t > f then f else t end) / (case when t > f then t else f end) as ratio
from (
select a.imageid as imageid, sum(case when a.result = 't' then 1 else 0 end) as t, sum(case when a.result = 'f' then 1 else 0 end) as f
from answers a, users u
where a.userid = u.id
and u.phase is not null
group by a.imageid
) img_stat
) img_stat_categ

) img_discr
where img_react.imageid = img_discr.imageid
group by ratio_categ, userid
) categ_user_avgtime
group by userid
) temp_tbl
</textarea>

<textarea id=taquery8>
/*categorize discr levels as per randomness measure in phase 2, then measure avg resp time by pp in phase 3*/
select userid, sum(case when ratio_categ = 1 then avg_time else 0 end) as categ_1, sum(case when ratio_categ = 2 then avg_time else 0 end) as categ_2, sum(case when ratio_categ = 3 then avg_time else 0 end) as categ_3, sum(case when ratio_categ = 4 then avg_time else 0 end) as categ_4
from(
select userid, ratio_categ, avg(avg_pic_reac) as avg_time
from (

select a.userid as userid, a.imageid as imageid, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, users u
where u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid
group by a.imageid, a.userid

) img_react,
(

select imageid, case when ratio < 0.25 then 1 when ratio < 0.5 then 2 when ratio < 0.75 then 3 else 4 end as ratio_categ
from (
select imageid, (case when t > f then f else t end) / (case when t > f then t else f end) as ratio
from (
select a.imageid as imageid, sum(case when a.result = 't' then 1 else 0 end) as t, sum(case when a.result = 'f' then 1 else 0 end) as f
from answers a, users u
where a.userid = u.id
and u.phase is not null
group by a.imageid
) img_stat
) img_stat_categ

) img_discr
where img_react.imageid = img_discr.imageid
group by ratio_categ, userid
) categ_user_avgtime
group by userid
</textarea>

<textarea id=taquery9>
/*categorize disrc levels as per x*y formula, then meaasure avg randomness in answers of pp in phase 2*/
select userid, sum(case when discr_categ = 1 then avg_randomness else 0 end) as categ_1, sum(case when discr_categ = 2 then avg_randomness else 0 end) as categ_2, sum(case when discr_categ = 3 then avg_randomness else 0 end) as categ_3, sum(case when discr_categ = 4 then avg_randomness else 0 end) as categ_4
from(

select userid, case when theor_discr >= 8 then 4 when theor_discr >= 4 then 3 when theor_discr >= 1 then 2 else 1 end as discr_categ, avg(randomness) as avg_randomness
from (
select userid, t * f as theor_discr, (case when t_resp > f_resp then f_resp else t_resp end) / (case when t_resp > f_resp then t_resp else f_resp end) as randomness
from (
select a.userid as userid, i.t as t, i.f as f, sum(case when a.result = 't' then 1 else 0 end) as t_resp, sum(case when a.result = 'f' then 1 else 0 end) as f_resp
from answers a, users u, images i
where a.userid = u.id and a.imageid = i.id
and u.phase is not null
group by a.userid, i.t, i.f
) img_stat
) img_stat_categ
group by userid, discr_categ

) discr_randomness
group by userid
</textarea>

<textarea id=taquery10>
/*categorize discr levels as per randomness measure in phase 2, then average resp time of all pp in phase 3*/
select ratio_categ, avg(avg_time) as avg_time
from(
select userid, ratio_categ, avg(avg_pic_reac) as avg_time
from (

select a.userid as userid, a.imageid as imageid, avg((a.reaction - uat.avg) / uat.stddev) as avg_pic_reac
from answers a,
(
select u.id as userid, avg(a.reaction) as avg, stddev(a.reaction) as stddev
from answers a, users u
where u.id = a.userid AND u.phase is null
group by u.id
) uat
where a.userid = uat.userid
group by a.imageid, a.userid

) img_react,
(

select imageid, case when ratio < 0.25 then 1 when ratio < 0.5 then 2 when ratio < 0.75 then 3 else 4 end as ratio_categ
from (
select imageid, (case when t > f then f else t end) / (case when t > f then t else f end) as ratio
from (
select a.imageid as imageid, sum(case when a.result = 't' then 1 else 0 end) as t, sum(case when a.result = 'f' then 1 else 0 end) as f
from answers a, users u
where a.userid = u.id
and u.phase is not null
group by a.imageid
) img_stat
) img_stat_categ

) img_discr
where img_react.imageid = img_discr.imageid
group by ratio_categ, userid
) categ_user_avgtime
group by ratio_categ
</textarea>

<textarea id=taquery11>
/*categorize disrc levels as per x*y formula, then average randomness in answers of all pp in phase 2*/
select discr_categ, avg(avg_randomness) as avg_randomness
from(

select userid, case when theor_discr >= 8 then 4 when theor_discr >= 4 then 3 when theor_discr >= 1 then 2 else 1 end as discr_categ, avg(randomness) as avg_randomness
from (
select userid, t * f as theor_discr, (case when t_resp > f_resp then f_resp else t_resp end) / (case when t_resp > f_resp then t_resp else f_resp end) as randomness
from (
select a.userid as userid, i.t as t, i.f as f, sum(case when a.result = 't' then 1 else 0 end) as t_resp, sum(case when a.result = 'f' then 1 else 0 end) as f_resp
from answers a, users u, images i
where a.userid = u.id and a.imageid = i.id
and u.phase is not null
group by a.userid, i.t, i.f
) img_stat
) img_stat_categ
group by userid, discr_categ

) discr_randomness
group by discr_categ
</textarea>

</div>






<div id=main_div>

	<div style='margin-top:50px;'>
		<b>Webmaster portal</b>
	</div>
	
	<div style='height:400px;display:table;margin:auto;'>
		<div style='display:table-cell;vertical-align:middle;'>
			<div style='width: 1200px; min-height: 400px;margin:auto;text-align:center;margin-top:30px;'>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery1").value;'>BY PIC</button>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery2").value;'>BY CATEG</button>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery3").value;'>BY L-CUES NBR</button>
				<br>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery6").value;'>BY QUARTILES</button>
				<br>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery4").value;'>DUAL</button>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery5").value;'>DUAL</button>
				<br>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery7").value;'>CONSISTENCY</button>
				<br>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery8").value;'>BY PP BY CATEG P3</button>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery9").value;'>BY PP BY CATEG P2</button>
				<br>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery10").value;'>AVG BY CATEG P3</button>
				<button onclick='document.getElementById("taquery").value=document.getElementById("taquery11").value;'>AVG BY CATEG P2</button>
				<br>
				<div style='margin:auto;text-align:center;margin-top:10px;margin-bottom:10px;'>
					Type your query in the textbox below,<br>or choose one from the available templates by clicking one of the above buttons,<br>then execute an action by clicking on PLOT or DOWNLOAD
				</div>
				<textarea id=taquery style='width: 800px; height: 400px;'></textarea><br>
				<button onclick='get_data_to_plot(document.getElementById("taquery").value);'>PLOT</button>
				<button onclick='download_data(document.getElementById("taquery").value);'>DOWNLOAD DATA</button>
			</div>
			<div id=chart_div style='width: 1200px; height: 600px;margin:auto;text-align:center;margin-top:30px;'></div>
			<div style='margin:auto;text-align:center;margin-top:5px;'>
				<button onclick='toggle_connect_dots();get_data_to_plot(document.getElementById("taquery").value);'>TOGGLE CONNECT DOTS</button>
			</div>
		</div>
	</div>
	
	<div style='margin-bottom:50px;'>
		<div></div>
	</div>

</div>

<iframe id=hidden_iframe_downloader style='display:none;'></iframe>

<script>


function get_data_to_plot(q) {
	sendRequest('analytics.php?dataformat=1&q=' + encodeURIComponent(q), handle_tabledata_reply);
}

function handle_tabledata_reply(req) {
	res = eval('(' + req.responseText + ')');
	var data = google.visualization.arrayToDataTable(res);
	var cde = document.getElementById('chart_div');
	var chart = new google.visualization.ScatterChart(cde);
	chart.draw(data, {lineWidth: cde.lineWidth});
}

function download_data(q) {
	var iframe = document.getElementById("hidden_iframe_downloader");
	iframe.src = 'analytics.php?dataformat=2&q=' + encodeURIComponent(q);   
}

function toggle_connect_dots() {
	var cde = document.getElementById('chart_div');
	cde.lineWidth = 2 - cde.lineWidth;
	if(isNaN(cde.lineWidth))
		cde.lineWidth = 2;
}

toggle_connect_dots();

</script>





</body>


</html>
