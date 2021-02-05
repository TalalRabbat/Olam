<?php
	include 'functions.php';
	session_start();

	$stationdata=$_SESSION["measurements"];
	//ouput the latest dataset of the full data
	echo $stationdata[sizeof($stationdata)-1]->prcp;
?>