<?php

require_once("functions.php");
require_once("php_headers.php"); // will set $conn to database

?><html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SHS Survey :: Lying Detection</title>
<meta name="description" content="We are a group of Master students from the École Polytechnique Fédérale de Lausanne (EPFL)
			performing a research project in collaboration with the Institute of Psychology at the University of Lausanne, Switzerland.
			We here perform a short study to find facial markers that make you judge this face rather lying or not lying.
			Knowing of these markers is key to our subsequent Master project we are not able to perform otherwise.
			Thus, we would be very grateful if you would take the time to go through these single faces, and for each one to judge as spontaneously as possible whether you think it is lying or not.
			The task will take about three minutes to perform.">
<meta name="keywords" content="SHS, Survey, Project, EPFL, Lausanne, UNIL, Lying, Detection, Psychology">
<meta name="author" content="Amer Chamseddine">
</head>






<body style="text-align:center">


<div id=main_div>

	<div style='margin-top:50px;'>
		<table align=center><tr><td style='width:400px;text-align:right;'><img style='max-height:100px;' src='http://ceat.epfl.ch/files/content/sites/ceat/files/shared/images/menus/ecussons/EPFL.png'></td><td style='min-width:200px;'>&nbsp;</td><td style='width:400px;text-align:left;'><img style='max-height:100px;' src='http://ceat.epfl.ch/files/content/sites/ceat/files/shared/images/menus/ecussons/UNIL.jpg'></td></tr></table>
	</div>
	<div style='margin-top:50px;'>
		<table align=center><tr><td style='min-width:250px;text-align:center;'><b>Lying Detection Survey</b></td></tr></table>
	</div>
	
	<div style='height:400px;display:table;margin:auto;'>
		<div style='display:table-cell;vertical-align:middle;text-align:left;margin:auto;width:700px;'>
			Dear participant,<br>
			<br>
			We are a group of Master students from the École Polytechnique Fédérale de Lausanne (EPFL)
			performing a research project in collaboration with the Institute of Psychology at the University of Lausanne, Switzerland,<br>
			in the scope of the course <a href="http://isa.epfl.ch/imoniteur_ISAP/!itffichecours.htm?ww_i_matiere=901934560&ww_x_anneeAcad=2011-2012&ww_i_section=1751774&ww_i_niveau=&ww_c_langue=en" target="_blank">Emotions, Self and Social Cognition</a>.<br>
			We here perform a short study to find facial markers that make you judge this face rather lying or not lying.
			Knowing of these markers is key to our subsequent Master project we are not able to perform otherwise.
			Thus, we would be very grateful if you would take the time to go through these single faces, and for each one to judge as spontaneously as possible whether you think it is lying or not.
			The task will take about five minutes to perform.<br>
			Obviously, we are thankful for each participant contributing. Yet, we would like to stress that your participation is voluntary,
			and that you can stop at any point. Your data will be treated anonymously, i.e., we will only record your age, sex, years of education, and country of origin.
			If you continue with the computer task, we do take this as your consent to use the data for research purpose only.
			If you have any further question, please do contact us at the following address <a href="mailto:shs@accandme.com">shs@accandme.com</a>.<br>
			<br>
			If you are still willing to participate, click the button below, you will continue to the actual task<br>
			<br>
			<!--<a href="newtake.php"><s>EPFL user</s></a><br>-->
			<!--<a href="newtake2.php">Guest user</a><br>-->
		</div>
	</div>
	
	<div style='margin-bottom:50px;'>
		<button id=take_button onclick='window.location.href = "newtake2.php";' disabled>Take survey</button>
		<br><br>
		<span style='color:#FF0000'>Thank you for your interest in taking our survey. We have reached the required number of participants</span>
	</div>

</div>

<div style="position:absolute;top:0px;visibility:hidden;"><img src="pics/neutral.jpg"></div>

<script>
document.getElementById("take_button").focus();
</script>

</body>


</html>
