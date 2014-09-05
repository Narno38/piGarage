// Version : 1.0.0
// Date : 2014-07-01
// File : /var/www/index.php
// Info : http://consultingdaylights.wordpress.com/
// Uses code from http://dronkert.net
// and http://www.instructables.com/id/Simple-and-intuitive-web-interface-for-your-Raspbe/?ALLSTEPS

//JavaScript, use pictures as buttons, sends and receives values to/from the Rpi
var button_17 = document.getElementById("button_17");
var button_19 = document.getElementById("button_19");

//this function sends and receives the pin's status
function change_pin (pin, status) {
	var request = new XMLHttpRequest();
	request.open( "GET" , "gpio.php?pin=" + pin + "&status=" + status );
	request.send(null);
	//receiving information
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {	return (parseInt(request.responseText)); }
		else if (request.readyState == 4 && request.status == 500) { alert ("server error"); return ("fail"); }
		else { return ("fail"); }
	}
}

//these are all the button's events, it just calls the change_pin function and updates the page in function of the return of it.
button_17.addEventListener("click", function () { 
	if ( button_17.alt === "off" ) {
		var new_status = change_pin ( 17, 0);
		if (new_status !== "fail") { button_17.alt = "on";	button_17.src = "on.png"; 	return 0;	}
		}
	if ( button_17.alt === "on" ) {
		var new_status = change_pin ( 17, 1);
		if (new_status !== "fail") { button_17.alt = "off";	button_17.src = "off.png"; 	return 0;	}
		}
} );

button_19.addEventListener("click", function () { 
	if ( button_19.alt === "off" ) {
		var new_status = change_pin ( 19, 0);
		if (new_status !== "fail") { button_19.alt = "on";	button_19.src = "on.png"; 	return 0;	}
		}
	if ( button_19.alt === "on" ) {
		var new_status = change_pin ( 19, 1);
		if (new_status !== "fail") { button_19.alt = "off";	button_19.src = "off.png"; 	return 0;	}
		}
} );
