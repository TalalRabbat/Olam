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

function check_username($db, $username){
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_stmt_init($db);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: admin_registration.php?signup=ERRORuserEXISTS");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultSTMT = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSTMT)){
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}



