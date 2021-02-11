<?php
include 'database_conn_func.php';
$conn =db_connect();
echo "Connected Successfully";
db_disconnect($conn);
?>