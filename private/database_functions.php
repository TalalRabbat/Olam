<?php

function find_admin_by_id($id) { 
    global $db; 

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE admin_id='" . $id . "'";
    $result = mysqli_query($db, $sql);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject;
}


?>