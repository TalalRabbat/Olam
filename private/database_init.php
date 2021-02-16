<?php 


//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
//THIS PAGE IS OBSOLETE, IT IS USED FOR REFERENCE ONLY
session_start();

define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("SHARED_PATH", PRIVATE_PATH . '/shared');

$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

require_once('../functions.php'); //importing general functions
require_once('database_conn_func.php'); //importing database functions
require_once('database_functions.php'); //importing query functions
require_once('database_value_validation.php'); //importing validation functions

$db=db_connect(); //starting the database connection and assigning to $db
$errors =[];
?>