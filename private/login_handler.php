<?php

require_once('../functions.php');
require_once('../private/placeholder_username_password.php');

if (isset($_POST['login-submit'])) {
    
    $gebruikersnaam = $_POST['username'];
    $wachtwoord = $_POST['password'];

    if (empty($gebruikersnaam) || empty($wachtwoord)) {
        header("Location: ../public/login.php?error=emptyvalues");
        exit();
    } else {
        
        if (verify_login($gebruikersnaam, $wachtwoord)){

            $error = "";
	        if(isset($_POST['login-submit'])) {
		        $var = (verify_login($_POST['username'], $_POST['password']) == True);
		        if($var == True){
			        session_start();
			        $_SESSION['logged_in'] = true;
			        header("Location: ../home.php");
                    exit();
		        }
		        if($var == False){
			        $error = "Username or password incorrect, please try again!";
                    header("Location: ../index.php");
                    exit();
		        }   
	        }
        } else {
            echo "whoopsiedoopsie";
        }
        
    }

} else {
    header("Location: ../index.php?error=redirected");
}