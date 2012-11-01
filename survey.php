<?php

require_once("functions.php");
require_once("php_headers.php"); // will set $conn to database


if(empty($_SESSION["userid"])) {
	header("Location: .");
	exit;
}


?><html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SHS Survey :: Lying Detection</title>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    

<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
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

<!--
<script src="http://www.ajax-cross-domain.com/cgi-bin/ACD/ACD.js?uri=(https://www.google.com/search?tbm=isch&amp;hl=en&amp;q=faces)">
</script>
//-->

<div id=main_div>


</div>

<script>
/*
if(document.images) {
	image_url = new Array();
	image_url[0] = "http://mydomain.com/image0.gif";
	image_url[1] = "http://mydomain.com/image1.gif";
	image_url[2] = "http://mydomain.com/image2.gif";
	image_url[3] = "http://mydomain.com/image3.gif";

	preload_image_object = new Image();
	for(i = 0; i < image_url.length; i++)
		preload_image_object.src = image_url[i];
}
*/

//document.getElementById("dyn_script").src = "";
//alert(ACD.responseText);

function show_loading_screen() {
	md = document.getElementById("main_div");
	md.innerHTML = "<div style='margin-top:50px;'><b>Welcome to our survey</b></div><div style='height:400px;display:table;margin:auto;'><div style='display:table-cell;vertical-align:middle;'>Loading... Please wait        <div style='posistion:relative;height:10px;width:200px;background-color:#c0c0c0;margin:auto;margin-top:20px;'><div id=loading_div style='position:absolute;height:10px;width:0px;background-color:#60f060'></div></div>           </div></div><div style='margin-bottom:50px;'><button disabled onclick=''>Wait</button></div>";
	md.training = 0;
}

function show_ready_screen() {
	md = document.getElementById("main_div");
	md.innerHTML = "<div style='margin-top:50px;'><b>Ready!</b></div>" +
			"<div style='height:400px;display:table;margin:auto;'><div style='display:table-cell;vertical-align:middle;width:600px;text-align:left;'>For the experiment to be effective, one must get familiar with the system before starting the actual measurements. For this reason we will start by showing you a few pictures to train yourself on the system. Your answers to these pictures will not be counted toward the final result.<br><br>INSTRUCTIONS: You will be shown a sequence of pictures; for every picture, if you think the person <b>is lying</b> press the <b>F key</b> on your keyboard; if you think otherwise press the <b>J key</b>.</div></div>" +
			"<div style='margin-bottom:50px;'><button id=start_button onclick='show_training_lying()'>Next</button></div>";
	document.getElementById("start_button").focus();
}

function show_training_screen() {
	md = document.getElementById("main_div");
	md.innerHTML = "<div style='margin-top:50px;'><b>Congratulations, you are now ready to start the experiment</b></div>" +
			"<div style='height:400px;display:table;margin:auto;'><div style='display:table-cell;vertical-align:middle;width:600px;text-align:left;'>It is worth noting that the timing matters in this experiment. For this reason, we kindly ask you to stay focused till the end, and keep your left index finger and right index finger on the F and J keys respectively. A green progress bar will be showing your progress. Please make your judgements as spontaneously as possible.<br><br>As soon as you cast a response to a picture, you move on to the next one, and you cannot go back. The whole experiment should take about 5 minutes.<br><br>From now on, your answers are recorded.</div></div>" +
			"<div style='margin-bottom:50px;'><button id=start_button onclick='start_survey()'>Start</button></div>";
	md.training = 0;
	document.getElementById("start_button").focus();
}

function show_training_lying() {
	md = document.getElementById("main_div");
	md.innerHTML = "<div style='margin:auto;margin-top:50px;margin-bottom:40px;'><b>Respond to this picture by 'lying'</b></div>" +
			"<table border=0 align=center><tr><td style='text-align:center;width:200px;'><img onclick='alert_instruction()' style='height:66px;width:70px;' src='img/key_f.png'><br><br><b>This person is lying</b></td><td style='text-align:center;'><img id=main_img style='height:519px;width:624px;' src='pics/L2.jpg'></td><td style='text-align:center;width:200px;'><img onclick='alert_instruction()' style='height:66px;width:70px;' src='img/key_j.png'><br><br><b>This person is not lying</b></td></tr></table>";
	md.training = 1;
}

function show_training_nlying() {
	md = document.getElementById("main_div");
	md.innerHTML = "<div style='margin:auto;margin-top:50px;margin-bottom:40px;'><b>Great! Now respond to this picture by 'not lying'</b></div>" +
			"<table border=0 align=center><tr><td style='text-align:center;width:200px;'><img onclick='alert_instruction()' style='height:66px;width:70px;' src='img/key_f.png'><br><br><b>This person is lying</b></td><td style='text-align:center;'><img id=main_img style='height:519px;width:624px;' src='pics/T1.jpg'></td><td style='text-align:center;width:200px;'><img onclick='alert_instruction()' style='height:66px;width:70px;' src='img/key_j.png'><br><br><b>This person is not lying</b></td></tr></table>";
	md.training = 2;
}

function show_more() {
	md = document.getElementById("main_div");
	md.innerHTML = "<div style='margin:auto;margin-top:50px;margin-bottom:40px;'><b>Lying Detection Study</b></div>" +
			"<div style='height:400px;display:table;margin:auto;'><div style='display:table-cell;vertical-align:middle;width:600px;text-align:left;'><b>Debriefing</b><br><br>It is certainly easy to imagine why humans are interested in the detection of lies as for instance in personal interactions and when it comes to possible breaches of law. The scientific literature offers lists of facial and non-facial deception cues that are thought to help in the identification of lying behavior. Even more, attempts have been made to develop machines that are able to detect liars. However, such machines have been found to be much less reliable than humans were found to be. Presumably, humans are better because we rely on cues that are not readily available to our overt decision making. The present study is aimed to test the contribution of such potential cues to the detection of lying.<br><br>Humans can perform decisions very quickly, taking one or more aspects of the presented information into consideration. Some of the information might be accessible to the person, while others might be covert. Recent studies have shown that the presentation of inconsistent information can impede on this quick, automated processing style. In the present case, this would mean that we not only present cues that are thought to indicate lying, but add other features that are commonly thought to reflect honesty. In more detail, we did this by superimposing on a single face picture i) cues of deception, ii) cues of deception and honesty, and iii) cues of honesty. We would expect the second stimuli to convey inconsistent information interfering with the decision making process as reflected by enhanced reaction times.<br><br>If you are interested in our work, or would like to know our results and findings (when they become available), or if you have any other question, suggestion, remark, or comment, feel free to contact us at <a href='mailto:shs@accandme.com'>shs@accandme.com</a>.</div></div>";
}

function start_survey() {
	md = document.getElementById("main_div");
	md.outstanding_req = 0;
	md.finished = 0;
	md.innerHTML = "<div style='margin:auto;margin-top:50px;'><b>Do you think this person is lying right now?</b></div>" +
			"<div style='posistion:relative;height:10px;width:600px;background-color:#c0c0c0;margin:auto;margin-top:30px;margin-bottom:30px;'><div id=prog_div style='position:absolute;height:10px;width:0px;background-color:#60f060'></div></div>" +
			"<table border=0 align=center><tr><td style='text-align:center;width:200px;'><img style='height:66px;width:70px;' src='img/key_f.png'><br><br><b>This person is lying</b></td><td style='text-align:center;'><img id=main_img style='height:519px;width:624px;'></td><td style='text-align:center;width:200px;'><img style='height:66px;width:70px;' src='img/key_j.png'><br><br><b>This person is not lying</b></td></tr></table>" +
			"<div id=time_div style='margin-bottom:50px;margin-top:30px;visibility:hidden;'>00:00:00</div>" +
			"<div style='height:10px;display:table;margin:auto;'><div style='display:table-cell;vertical-align:middle;'>     </div></div>";
	mi = document.getElementById("main_img");
	md.current = 0;
	md.t = 0;
	md.f = 0;
	md.startDate = (new Date().getTime());
	md.interval = setInterval("update_time();", 500);
	
	mi.src = "img/fc.jpg";
	md.FixationCross = 1;
	setTimeout("show_face_pic();", 1000);
}

function alert_instruction() {
	alert("You should not use the mouse. Please use the F and J keys of your keyboard.");
}

function show_submitting_screen() {
	md = document.getElementById("main_div");
	clearInterval(md.interval);
	md.innerHTML = "<div style='margin-top:50px;'><b>You're done!</b></div><div style='height:400px;display:table;margin:auto;'><div style='display:table-cell;vertical-align:middle;'>Please wait while we save your answers</div></div><div style='margin-bottom:50px;'><button disabled onclick=''>Wait</button></div>";
}

function show_stats_screen() {
	md = document.getElementById("main_div");
	md.innerHTML = "<div style='margin-top:50px;'><b>Thank you</b></div><div style='height:400px;display:table;margin:auto;'><div style='display:table-cell;vertical-align:middle;'>Thank you for taking part in our study.<br>Your answers were successfully recorded.<br><br>If you are interested to know more about our study, click <a href='javascript:show_more();'>here</a>.<br><div id=chart_div style='width: 1px; height: 1px;'></div><br></div></div><div style='margin-bottom:50px;'><button onclick='alert(\"Copy the page URL and post it on your Facebook!\")'>Tell your friends</button></div>";
	//It is now safe to navigate away from this page.<br><br>
	sendRequest('get_stats.php?finish=1', handle_stats_reply);
}

function T() {
	md = document.getElementById("main_div");
	submit_answer("t");
	md.t++;
	go_to_next();
}

function F() {
	md = document.getElementById("main_div");
	submit_answer("f");
	md.f++;
	go_to_next();
}

function submit_answer(ans) {
	md = document.getElementById("main_div");
	pic_id = md.pics[md.current].id;
	md.outstanding_req++;
	sendRequest('submit_answer.php',handle_submit_reply, "pic_id=" + pic_id + "&answer=" + ans + "&time=" + ((new Date().getTime()) - md.PicDisplayedTime));
}

function handle_submit_reply(rep) {
	md = document.getElementById("main_div");
	md.outstanding_req--;
	if(!md.outstanding_req && md.finished) {
		show_stats_screen();
	}
}

function handle_stats_reply(req) {
	res = eval('(' + req.responseText + ')');
	//md = document.getElementById("main_div");
	//md.t;
	//md.f;
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Categories');
	data.addColumn('number', 'Not lying');
	data.addColumn('number', 'Lying');
	data.addColumn('number', 'Average Reaction Time (in deci-seconds)');
	for(i = 0; i < res.stats.length; i++) {
		data.addRows([ [res.stats[i].discr, res.stats[i].t-1+1, res.stats[i].f-1+1, res.stats[i].reaction*10] ]);
	}
	var options = {
		title: 'Your nerdy stats',
		hAxis: {title: 'Categories', titleTextStyle: {color: 'red'}}
	};
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	chart.draw(data, options);
}

function go_to_next() {
	md = document.getElementById("main_div");
	mi = document.getElementById("main_img");
	md.current++;
	if(md.current < md.pics.length) {
		mi.src = "img/fc.jpg";
		md.FixationCross = 1;
		pd = document.getElementById("prog_div");
		pd.style.width = Math.floor(600 * md.current / md.pics.length);
		setTimeout("show_face_pic();", 300);
	} else {
		md.finished = 1;
		show_submitting_screen();
	}
}

function show_face_pic() {
	md = document.getElementById("main_div");
	mi = document.getElementById("main_img");
	mi.src = md.pics[md.current].path;
	md.PicDisplayedTime = (new Date().getTime());
	md.FixationCross = 0;
}

function update_time() {
	md = document.getElementById("main_div");
	td = document.getElementById("time_div");
	t = Math.floor(((new Date().getTime()) - md.startDate) / 1000);
	s = t % 60;
	t = Math.floor(t / 60);
	m = t % 60;
	h = Math.floor(t / 60);
	md.elapsed_time = (h < 10 ? "0" : "") + h + (m < 10 ? ":0" : ":") + m + (s < 10 ? ":0" : ":") + s;
	td.innerHTML = md.elapsed_time;
}

document.onkeypress = function (e) {
	c = String.fromCharCode(e.charCode);
	md = document.getElementById("main_div");
	if(md.training) {
		if(md.training == 1 && c != "f" && c != "F") {
			alert("No, you should press the F key.");
			return false;
		}
		if(md.training == 2 && c != "j" && c != "J") {
			alert("No, you should press the J key.");
			return false;
		}
		if(md.training == 1)
			show_training_nlying();
		else
			show_training_screen();
		return false;
	}
	
	if(!md.FixationCross) {
		if(c == "j" || c == "J") {
			T();
			return false;
		} else if(c == "f" || c == "F") {
			F();
			return false;
		}
		//if(c == "a") md.finished = 1;
	}
	return true;
}

function check_loading_progress() {
	md = document.getElementById("main_div");
	if(md.preload_image_object.complete) {
		md.preload_image_index++;
		if(md.preload_image_index < md.pics.length) {
			md.preload_image_object.src = md.pics[md.preload_image_index].path;
			ld = document.getElementById("loading_div");
			ld.style.width = Math.floor(200 * md.preload_image_index / md.pics.length);
			setTimeout("check_loading_progress();", 10);
		} else {
			show_ready_screen();
		}
	} else {
		setTimeout("check_loading_progress();", 10);
	}
}

function handle_images_reply(req) {
	res = eval('(' + req.responseText + ')');
	md = document.getElementById("main_div");
	md.pics = res.all_pics;
	md.preload_image_object = new Image();
	md.preload_image_index = -1;
	/*for(i = 0; i < md.pics.length; i++)
		md.preload_image_object.src = md.pics[i].path;*/
	check_loading_progress();
	//show_ready_screen();
	
	// also preload these
	preload_key_image_object = new Image();
	preload_key_image_object.src = "img/key_f.png";
	preload_key_image_object.src = "img/key_j.png";
	preload_key_image_object.src = "img/fc.jpg";
}

sendRequest('get_images.php', handle_images_reply);

show_loading_screen();


</script>



</body>


</html>
