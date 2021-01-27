<?php
	session_start();
	include 'functions.php';
	$station_id=$_GET['station'];
	parse_bin("weatherdata/$station_id.bin",$station_id); 
	$_SESSION["measurements"]=$measurements;
	
	
?>