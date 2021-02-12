<?php
	include 'functions.php';    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="./images/icon.png">
  <!--Opening code for bootstrap and login-->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Talal Rabat">
  <meta name="generator" content="Jekyll v3.8.6">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
  <meta name="theme-color" content="#563d7c">
  <!--Title of webpage-->
  <title>Giuliani Inc.</title>
  <!--Bootstrap makeup for the website-->
  <style>
  	html,
    /*set style for body*/
    body {
      height: 100%;
    }
    body {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-align: center;
      align-items: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-repeat: no-repeat, repeat;
      background-position: center;
    }
   /*set style for signin form*/

    .form-signin {
      text-align: center;
      width: 100%;
      max-width: 330px;
      padding: 15px;
      margin: auto;

    }
    set style for sin
    .form-signin .checkbox {
      font-weight: 400;
    }

    .form-signin .form-control {
      position: relative;
      box-sizing: content-box;
      height: auto;
      padding: 10px;
      font-size: 16px;
    }

    .form-signin .form-control:focus {
      z-index: 2;
    }

    .form-signin input[type="text"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
    }

    .form-signin input[type="password"] {
      width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
    }

    .form-signin input[type="submit"] {
      background-color: #184893;
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
      box-shadow: 0 10px 16px 0 rgba(0,0,0,0.24);
      -webkit-transition-duration: 0.2s; /* Safari */
      transition-duration: 0.2s;
    }

    .form-signin input[type="submit"]:hover {
      background-color: #DC292A;
    }

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;        
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
          .section {
            height: 100vm;
            margin-bottom: 450px;


          }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

  </head>
  <body class="text-center">
    
    
  <div class="section">

     <video autoplay="true" loop="true" muted>
      <source src="/images/video.mp4" type="video/mp4">
     </video> 
     
     
    
    <form class="form-signin" action="private/login_handler.php" method="POST">
      
      <h2 class="h3 mb-3 font-weight-normal">Please log in</h2>
      <h6 class="h6 mb-6 font-weight-normal text-danger"><?php echo "error"; ?></h6>
      
      <label for="inputEmail" class="sr-only">Username</label>
      <input name="username" type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
      
      <label for="inputPassword" class="sr-only">Password</label>
      <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
      
      <div class="checkbox mb-3"></div>
      
      <input value="Enter" name="login-submit" class="btn btn-lg btn-primary btn-block" type="submit">     

      <p class="mt-5 mb-3 text-muted">Olam &copy; Copyright <?php echo date("Y"); ?></p>

      
    </form>
    <form action="admin_login_page.php">
        <input type="submit" value="Admin" />
      </form>
  </div>
  
  </body>
</html>
<?php 
	
?>
