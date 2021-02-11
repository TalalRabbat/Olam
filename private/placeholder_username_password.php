<?php


    //$USER_USERNAME = "user";
	//$USER_PASSWORD = '$argon2i$v=19$m=1024,t=2,p=2$RGVNME4weFFwMmMyd01IZw$a28OeXYplLovOamT/0VITKf3kMsWi+mQVMJjAVKlxcw';

    $USER_USERNAME2 = "USER";
	$USER_PASSWORD2 = "PASSWORD";

    $usernameblabla = "something";

    function checkUsername($variable){
        global $USER_USERNAME2;
        if($variable == $USER_USERNAME2){
            return true;
        }
    }

    function checkPassword($password){
        global $USER_PASSWORD2;
        if($password == $USER_PASSWORD2){
            return true;
        }
    }


?>