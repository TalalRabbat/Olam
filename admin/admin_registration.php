<?php 

require('../private/database_init.php'); 

// if (isset($_GET['signup'])){
//     header("Location: registration_succes.php");
// }
// ?>



<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>User Registration</title>
    </head>
    
    <body>
        <div class="main-header">            
            <header>
                <div class="container2">
                    <h1>Register</h1>
                </div>
            </header>

            <!-- <nav class="navbar">
                <a href="frontpage.php">Home</a>        
            </nav> -->
        </div>

        <!--add logic that displays form input errors-->
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "nopwdmatch") {
                echo '<p class="pwdmatcherror"> Your passwords did not match </p>';
            } else if ($_GET['error'] == "invalidemail") {
                echo '<p class="emailerror"> The email you entered was invalid </p>';
            }
        } 
        
        
        ?>
        
        <form action="admin_registration_logic.php" method="POST">        
        
        <p>Please fill in this form to create an account.</p>

        <label for="username"><strong>Username</strong></label>
        <input type="text" placeholder="Username" name="username" required>       

        <!-- <label for="voornaam"><strong>Voornaam</strong></label>
        <input type="text" placeholder="Voornaam" name="voornaam" required>        

        <label for="achternaam"><strong>Achternaam</strong></label>
        <input type="text" placeholder="Achternaam" name="achternaam" required>        

        <label for="email"><strong>Email</strong></label>
        <input type="text" placeholder="example@email.com" name="email" required>         -->

        <label for="password"><strong>Password</strong></label>
        <input type="password" placeholder="password" name="password" required>        

        <label for="password-repeat"><strong>Repeat Password</strong></label>
        <input type="password" placeholder="password" name="password_repeat" required>        
        <hr>
        <button type="submit" class="registerbtn">Register</button>       
        

        
        </form>
        

        <footer class="footer">
            <hr>
            &copy;<?php echo date('Y');?> Olam
        </footer>
    </body>
</html>