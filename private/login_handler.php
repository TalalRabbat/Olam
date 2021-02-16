<?php

require_once('../functions.php');
//require_once('../private/placeholder_username_password.php');
require_once('../private/database_conn_func.php');
require_once('../private/database_functions.php');

$db=db_connect();

$username = $_POST['username'];
$password = $_POST['password'];
user_log_in($db, $username, $password);



// if (isset($_POST['login-submit'])) {
    
//     $gebruikersnaam = $_POST['username'];
//     $wachtwoord = $_POST['password'];

//     $db=db_connect();

//     if (empty($gebruikersnaam) || empty($wachtwoord)) {
//         header("Location: ../public/login.php?error=emptyvalues");
//         exit();
//     } else {
//         $sql = "SELECT *";
//         $sql .= " FROM users";
//         $sql .= " WHERE username=?;";
//         $statement = mysqli_stmt_init($db);

//         if (!mysqli_stmt_prepare($statement, $sql)) {
//             header("Location: ../public/login.php?error=sqlloginerror1");
//             exit();
//         } else {
//             mysqli_stmt_bind_param($statement, "s", $gebruikersnaam);
//             mysqli_stmt_execute($statement);
//             $login_statement_result = mysqli_stmt_get_result($statement);
        
//             if ($row = mysqli_fetch_assoc($login_statement_result)) {
//             //if (true) {
//                 //$passwordchecker = verify_login($wachtwoord, $row['wachtwoord']);
//                 $passwordchecker = password_verify($wachtwoord, $row['wachtwoord']);
//                 $passwordchecker = true;
//                 if ($passwordchecker == false) {
//                     header("Location: ../index.php?error=wrongpassword1");
//                     exit();
//                 } else if ($passwordchecker == true) {
//                     session_start();
//                     $_SESSION['sessgebruikersnaam'] = $row['Gebruikersnaam'];
//                     $_SESSION['logged_in'] = true;

//                     header("Location: ../home.php?login=success");
//                     exit();
//                 } else {
//                     header("Location: ../index.php?error=wrongpassword2");
//                     exit();
//                 }
//             } else {
//                 header("Location: ../index.php?error=nouserfound");
//                 exit();
//             }
//         }
//     }
// } else {
//     header("Location: ../index.php?error=redirected");
// }
