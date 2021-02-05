<?php
	include 'functions.php';
	session_start();

	$stationdata=$_SESSION["measurements"];
	$station_id=$_GET['station'];
	$output = "";
	if(check_precipitation_station($station_id) == true){
		//output the latest dataset of the full data
		$output .= "<h3 style='color:#7D7D7D;'>Temp and Downfall</h3><br/><table id='prcp_table' style='width:100%;' border='1px'><thead><th>Date and Time</th><th>   Downfall</th><th>Temp</th></thead>";
		$output .= '<tbody onscroll="pauseTable()">';
		$row = "";
		for($measurementIndex = 0; $measurementIndex < sizeof($stationdata); $measurementIndex++){
			$precipitation = $stationdata[$measurementIndex]->wdsp;
			$temp = $stationdata[$measurementIndex]->temp;
			$time = $stationdata[$measurementIndex]->date_and_time;
			$time = $time->format('d/m/Y H:i:s');
			$row = "<tr><td>" . $time . "</td><td>" . $precipitation . "&nbsp; mm/w</td><td>" . $temp . "&nbsp;</td></tr>" . $row;
		}
		$output .= $row . "</tbody></table>";
		$output .= '<p style="width: 100%;"><button onclick="exporttoxml(\'#prcp_table\')" style="width: 50%;">Download Table</button><button onclick="continueTable()" style="width: 50%;">Refresh Table</button></p>';
	}
	echo $output;
?>