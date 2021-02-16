<?php 

if(isset($_POST["submit"])){
    
    $wachtwoord = $_POST['password'] ?? [''];
    $wachtwoord_her = $_POST['password_repeat'] ?? [''];
    $gebruikersnaam = $_POST['username'] ?? [''];

    require_once('../private/database_conn_func.php');
    require_once('../private/database_functions.php');
    require_once('../functions.php');

    $db=db_connect();

    //check if variables not empty
    if($wachtwoord != $wachtwoord_her){
        header("Location: admin_registration.php?error=noadminpwdmatch");
        exit();

    //check username   
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $gebruikersnaam)) {
        header("Location: admin_registration.php?error=badusername&email=" .$email);
        exit();
    } else {
        if(check_admin_username($db, $gebruikersnaam) == true){
            header("Location: admin_registration.php?signup=ERRORuserEXISTS");
            exit();
            
        } else {
            $username = $gebruikersnaam;
            $password = password_hash($wachtwoord, PASSWORD_DEFAULT);

            $stmt = $db->prepare("INSERT INTO admins (admin_name, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);

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

