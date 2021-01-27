<?php
	include 'functions.php';
	session_start();

	$stationdata=$_SESSION["measurements"];
	$output = "";
	$station_id=$_GET['station'];
	if(check_temp_station($station_id) == true){
		//ouput the latest dataset of the full data
		if (array_key_exists(sizeof($stationdata)-1,$stationdata)){
			$temperature=$stationdata[sizeof($stationdata)-1]->temp;
		$output .= "<h1>Current temperature: <br>". $temperature . "&#8451;</h1>";
		} 
		else{
		$output .= "<p><h1 style=\"color:red\">No data for this station</h1></p>";
		}
	}
	echo $output; 
?>