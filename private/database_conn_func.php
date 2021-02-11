<?php 

function db_connect(){

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "rootroot";
    $db = "olam";
   
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

    return $conn;
}

function db_disconnect($conn){
    $conn -> close();
}

?>