<?php

require_once('../functions.php');
//require_once('../private/placeholder_username_password.php');
require_once('../private/database_conn_func.php');
require_once('../private/database_functions.php');

$db = db_connect();

$username = $_POST['username'];
$password = $_POST['password'];
user_log_in($db, $username, $password);
