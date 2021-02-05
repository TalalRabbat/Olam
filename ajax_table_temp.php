<?php
	include 'functions.php';
	session_start();
	
	$stationdata=$_SESSION["measurements"];
	$station_id=$_GET['station'];
	$output = "";
	if(check_temp_station($station_id) == true){
		//output the latest dataset of the full data
		$output .= "<h3>Daily temperature measurements</h3><table style='width:80%;' id='temp_table' border='1px'><thead><th>Date and Time</th><th>Temperature</th></thead>";
		$output .= '<tbody onscroll="pauseTable()">';
		$row = "";
		$array = array();
		for($measurementIndex = 0; $measurementIndex < sizeof($stationdata); $measurementIndex++){
			$time = $stationdata[$measurementIndex]->date_and_time;
			$time = $time->format('d/m/Y H:i:s');
			$checkdate = substr($time,0, 5);
			$checktime = substr($time, 11, 17);
			if($checktime == "12:00:00"){
				if(array_key_exists($checkdate, $array) == true){
				}
				else{
					$temp = $stationdata[$measurementIndex]->temp;
					$array[$checkdate] = $temp;
					$row = "<tr><td>" . $time . "</td><td>" . $temp . "&#8451;</td></tr>" . $row;
				}	
			}
		}
		if($array < 1){
			$output .= "<tr><td> No Data </td><td> No Data </td></tr>";
		}
		$output .= $row . "</tbody></table>";
		$output .= '<p style="width: 80%;"><button onclick="exporttoxml(\'#temp_table\')" style="width: 50%;">Download Table</button><button onclick="continueTable()" style="width: 50%;">Refresh Table</button></p>';
	}
	echo $output;
	//test
?>