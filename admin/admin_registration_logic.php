<?php 

require_once('../private/database_conn_func.php');
require_once('../functions.php');
$db=db_connect();
if(is_post_request()){
    
    $wachtwoord = $_POST['password'] ?? [''];
    $wachtwoord_her = $_POST['password_repeat'] ?? [''];
    $gebruikersnaam = $_POST['username'] ?? [''];

    //check if variables not empty
    if($wachtwoord != $wachtwoord_her){
        header("Location: admin_registration.php?error=nopwdmatch");
        exit();

    //check username   
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $gebruikersnaam)) {
        header("Location: admin_registration.php?error=badusername&email=" .$email);
        exit();
    } else {
        $stmt_check = $db->prepare("SELECT * FROM users WHERE username =?");
        $stmt_check->bind_param("s", $gebruikersnaam);
        $stmt_check->execute();
        if($stmt_check->num_rows > 0){
            header("Location: admin_registration.php?signup=ERRORuserEXISTS");
            exit();
        } else {
            $stmt_check->close();
            
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);

            $username = $gebruikersnaam;
            $password = password_hash($wachtwoord, PASSWORD_BCRYPT);

            $stmt->execute();
            $stmt->close();
            $db->close();
            header("Location: admin_registration.php?signup=success");
            exit();
 
        }

    }
    
} else {
    //if $_POST is NOT set, redirect to registration form:
    echo('whoops');
}

?>