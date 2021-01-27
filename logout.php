<?php
	/*Destroy login session and redirect back to login screen*/
	session_start();
	session_destroy();
	header('location: index.php');
?>