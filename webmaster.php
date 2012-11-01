<?php

require_once("functions.php");
require_once("php_headers.php"); // will set $conn to database


if(!empty($_GET["delete"])) {
	sql_query(query_delete_participant_answers($_GET["delete"]), $conn);
	sql_query(query_delete_participant($_GET["delete"]), $conn);
	header("Location: ?");
	exit;
}


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







?><html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SHS Survey :: Lying Detection</title>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    

<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
google.load('visualization', '1', {packages:['gauge']});
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


<div id=main_div>

	<div style='margin-top:50px;'>
		<b>Webmaster portal</b>
	</div>
	
	<div style='height:400px;display:table;margin:auto;'>
		<div style='display:table-cell;vertical-align:middle;'>
			<?php echo $stats_html; ?><br>
			<div id=userid_div style='margin:auto;text-align:center;'></div><br>
			<div id=chart_div style='width: 400px; height: 200px;margin:auto;text-align:center;'></div><br>
		</div>
	</div>
	
	<div style='margin-bottom:50px;'>
		<button onclick='alert("Coucou!");'>...</button>
	</div>

</div>



<script>


function show_stats_of(userid) {
	sendRequest('get_stats.php?userid=' + userid, handle_stats_reply);
	document.getElementById('userid_div').innerHTML = "userid: <a href='?byimage=1&filter=" + userid + "'>" + userid + "</a>";
}

function handle_stats_reply(req) {
	res = eval('(' + req.responseText + ')');
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Categories');
	data.addColumn('number', 'Trusty Count');
	data.addColumn('number', 'Non-Trusty Count');
	data.addColumn('number', 'Average Reaction Time (in deci-seconds)');
	for(i = 0; i < res.stats.length; i++) {
		data.addRows([ [res.stats[i].discr, res.stats[i].t-1+1, res.stats[i].f-1+1, res.stats[i].reaction*10] ]);
	}
	var options = {
		title: 'Nerdy stats',
		hAxis: {title: 'Discrepancy Categories', titleTextStyle: {color: 'red'}}
	};
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	chart.draw(data, options);
}

function sort_by_lo() {
	qsf = document.getElementById('query_string_form');
	qsf.order.value = 'olo';
	qsf.submit();
}

function sort_by_hi() {
	qsf = document.getElementById('query_string_form');
	qsf.order.value = 'ohi';
	qsf.submit();
}




</script>



</body>


</html>
