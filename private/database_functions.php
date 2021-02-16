<?php

//ADMIN//
//ADMIN//
//ADMIN//

function check_admin_username($db, $username){
    $sql = "SELECT * FROM admins WHERE admin_name = ?";
    $stmt = mysqli_stmt_init($db);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: admin_registration.php?signup=ERRORadminuserEXISTS");
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

function admin_log_in($db, $username, $wachtwoord){
    $var = check_admin_username($db, $username);

    if ($var === false) {
        header("Location: ../admin_login_page.php?signup=WRONGadminusername");
        exit();
    } 

    $hashedPassword = $var["password"];
    $checkPassword = password_verify($wachtwoord, $hashedPassword);

    if ($checkPassword === false){ //CHANGE TO FALSE
        header("Location: ../admin_login_page.php?signup=WRONGadminpassword");
        exit();
    } else {
        session_start();
        $_SESSION["username"] = $var["admin_name"];
        header("Location: admin_registration.php?");
        exit();
    }
}

//CLIENT//
//CLIENT//
//CLIENT//

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

function user_log_in($db, $username, $wachtwoord){
    $var = check_username($db, $username);

    if ($var === false) {
        header("Location: ../index.php?signup=WRONGusername");
        exit();
    } 

    $hashedPassword = $var["password"];
    $checkPassword = password_verify($wachtwoord, $hashedPassword);

    if ($checkPassword === false){
        header("Location: ../index.php?signup=WRONGpassword");
        exit();
    } else {
        session_start();
        $_SESSION["username"] = $var["username"];
        header("Location: ../home.php?");
        exit;
    }
}



