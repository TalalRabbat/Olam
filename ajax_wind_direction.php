<?php
	include 'functions.php';
	session_start();
	
	$stationdata=$_SESSION["measurements"];
	$output = "";
	$station_id=$_GET['station'];
	if(check_wind_station($station_id) == true){
	//ouput the latest dataset of the full data
		if (array_key_exists(sizeof($stationdata)-1,$stationdata)){
			$degrees=$stationdata[sizeof($stationdata)-1]->wnddir;
		//createCompass($degrees); 
		$output .= "<h3>Current wind direction:</h3> ".wnddir_to_words($degrees) . "&nbsp; (" . $degrees . "&#176;)";
		$output .= "<img  id=\"compass\"  style=\"width:100%;\"src=\"compass.png\" alt\"compass\"/>";
		} 
		else{
		$output .= "<p><h1 style=\"color:red\">No data for this station</h1></p>";
		}
	}
	echo $output;
	
?>