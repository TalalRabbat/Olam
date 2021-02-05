<?php

	include 'functions.php';
	session_start();

	$stationdata=$_SESSION["measurements"];
	$output = "";
	$station_id=683300;
	if(check_temp_station($station_id) == true){
		//ouput the latest dataset of the full data
		if (array_key_exists(sizeof($stationdata)-1,$stationdata)){
			$precipitation=$stationdata[sizeof($stationdata)-1]->prcp;
		    $output .= "<h1>Current precipitation: <br>". $precipitation . "&#8451;</h1>";
		} 
		else{
		$output .= "<p><h1 style=\"color:red\">No data for this station</h1></p>";
		}
	}
	echo $output; 

?>