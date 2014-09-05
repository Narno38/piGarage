<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Version : 1.0.0
Date : 2014-07-01
File : /var/www/index.php
Info : http://consultingdaylights.wordpress.com/
Uses code from http://dronkert.net
and http://www.instructables.com/id/Simple-and-intuitive-web-interface-for-your-Raspbe/?ALLSTEPS
-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-gb" xml:lang="en-gb">
	<head profile="http://www.w3.org/2005/10/profile">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>piGarage</title>
		<style type="text/css">
			img#view { display: block; }
		</style>
		<script type="text/javascript">
			var shotinterval = 5;     // Seconds between shots
			var shottimer = null;     // Countdown timer to the next shot
			var shootingnow = false;  // To avoid parallel execution

			// Start the timer
			function start() { shottimer = window.setTimeout(shoot, 1000 * shotinterval); }

			// Stop the timer, return previous state (was it running? true/false)
			function stop() {
				if (shottimer) {
					window.clearTimeout(shottimer);
					shottimer = null;
					return true;
				}
				return false;
			}

			// Stop the timer when running, start when not running
			// Avoid undefined state by checking for image refresh in progress
			function toggle() {
				if (!shootingnow) {
					var wasrunning = stop(), node;
					if (node = document.getElementById("ctrl"))	node.innerHTML = wasrunning ? "Start" : "Stop";
					if (!wasrunning) shoot();
				}
			}

			// Refresh the webcam image by re-setting the src attribute
			function shoot() {
				shootingnow = true;
				var img; 
				if (img = document.getElementById("view")) img.src = "webcam.php?" + Date.now();
				start();
				shootingnow = false;
			}
		</script>
	</head>

	<body style="background-color: white;" onload="start()">
	<center>
		<img id="view" src="webcam.php" alt="[webcam]" title="Webcam"/>
		<a id="ctrl" href="#" onclick="toggle()">Stop</a>
		<br/>
		<?php
		//this php script generate the first page in function of the gpio's status
		// slightly altered from original version from TheFreeElectron to effectively populate the arrays and change the pins statuses
		$status = array (0,0); 
		$pin = array (17,19);
		for ($i = 0; $i < count($status); $i++) {
			//set the pin s mode to output and read them
			system("/usr/local/bin/gpio mode ".$pin[$i]." out");
			exec ("/usr/local/bin/gpio read ".$pin[$i], $status[$i], $return );
			//if off
			if ($status[$i][0] == 0 ) { echo ("<img id='button_".$pin[$i]."' src='off.png' alt='off'/><br/><br/>");	}
			//if on
			if ($status[$i][0] == 1 ) {	echo ("<img id='button_".$pin[$i]."' src='on.png' alt='on'/><br/><br/>");	}	 
		}
		?>
		<br/><br/>
	<!-- javascript -->
	<script src="script.js"></script>
	</center>
	</body>
</html>
