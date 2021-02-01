<?php
  include 'functions.php';

  /*This code checks if the user is logged in*/
  session_start();
  check_login();
?>
<!DOCTYPE html>
<html lang="en">
<!--Head of webpage-->
<head>
  <!--Title of the webpage-->
  <title>Weather Information</title>
  <link rel="icon" href="./images/icon.png">
  <!--Opening code for bootstrap-->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- script for chart-->
  <script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>

  <style type="text/css">
      html,
    /*set style for body*/
    body {
      height: 100%;
      background-color: #f5f5f5;
      margin: 0;
    }

    .mask{
      margin-top: 100px;
    }

  /* Rounded border */
  hr.rounded {
      border-top: 8px solid #bbb;
    border-radius: 5px;
  }

   /*set style for tekst blok*/
    #textRow{ 
      width: 100%;
      height: 100%;
      margin: 0px;
      border: 0px;
      margin: auto;
      padding-top: 10px;
      position: relative;
    }

    #textColumn {
      float: left;
      width: 40%;
    }

    #imgColumn {
      float: left;
      text-align: center;
      width: 60%;
    }

    #textRow:after {
      content: "";
      display: table;
      clear: both;
    }

    figure {
      padding-left: 30px;
      padding-top: 15px;
    }

    h4 {
      color:#a0c800;
      padding-bottom: 15px;
    }

    figcaption {
      color: #0b4b52;
      font-style: italic;
      font-size: small;
    }

  footer {
      height: 30px;
      width: 100%;
      background-color: #333333;
      padding: 0px;
      margin: 0px;
      margin-bottom:0px;
      border: 0px;
      text-align: center;
      color: #7D7D7D;
    }
  </style>
</head>

<body>

<header>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">

    <a class="navbar-brand" href="home.php">
      <img src="./images/logo.png" width="180" height="60" alt="Logo Olam" style="background-color:#FFFFFF; padding: 2px; ">
    </a>
    <div class="container-fluid">
      <button
        class="navbar-toggler"
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#navbarExample01"
        aria-controls="navbarExample01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarExample01">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="maps.php">Stations</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="help.php">Help</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Log out</a>
          </li>
        </ul>
  
      </div>

    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>

    </div>
  </nav>
    <!-- Navbar -->

  <!-- Background image -->
  <div
    class="p-5 text-center bg-image"
    style="
      background-image: url('./images/banner.jpg');
      height: 400px;
      margin-top: 58px;
      box-shadow:inset 0 0 0 2000px rgba(0,0,0,0.5);
    "
  >
    <div class="mask">
      <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-white">
          <h1 class="mb-3">Help</h1>
          <h5 class="mb-3">This page provides answers to questions regarding the use of the Olam Weather Application. </h5>
        </div>
      </div>
    </div>
  </div>
  <!-- Background image -->
</header>

<br/>
<br/>


  <!--content divider-->
  <div class="container">
	  
    <div class="row">
      
      <div class="col-sm-6">
      <h4>Homepage</h4>
      <p>
        This page is the first page you visit after logging-in and contains a brief welcome message. It also shows the weather data of the weather station <b>Name of your whether station</b>.
        <br />
        To go back to the homepage, click <b>Home</b> on the navigation bar.
      </p>
      </div>
      <div class="col-sm-6">
        <figure>
          <a href="home.php"><img src="./images/logo.png" width="50%" alt="Olam Logo"></a>
          <figcaption>
            You can always click on <b>the Olam logo</b> on the navigation bar to go straight to the homepage
          </figcaption>
        </figure>
      </div>
    </div>
<hr class="rounded">
    <div class="row">
    
      <div class="col-sm-6">
        <h4>Map of stations</h4>
        <p>
          Clicking on <b>Stations</b> sends you to the webpage with a map of the world, which contains a <b>total of 9 markers</b>.
          <hr />
        </p>
        <p style="padding-top: 5px">
          <b>Every red marker</b> represents an individual weather station.  
        </p>
          <hr />
        <p style="padding-top: 5px">
          <b>The single blue marker</b> represents your current location, also known as your <b>Geolocation</b>.
        </p>
      </div>
      <div class="col-sm-6">
        <figure>
          <img src="./images/markers.png" alt="Red and blue marker" width="51%">
          <figcaption style="padding-right: 12px">
            Left: Weather Station marker &emsp; | &emsp; Right: Geolocation marker.
          </figcaption>
        </figure>
      </div>
    </div>
<hr class="rounded">
    <div class="row">
      
      <div class="col-sm-6">
      <h4>Selecting a station</h4>
      <p>
        Clicking a <b>red marker</b> opens a window that shows the station's name and a selection menu.
      </p>
      </div>
      <div class="col-sm-6">
        <figure>
          <img src="./images/infowindow.png" alt="infowindow" width="63%">
          <figcaption>
            Hover your mouse over a weather station marker of your choosing as shown on the left,
            <br />
            then left-click on that marker to get the result as shown on the right.
          </figcaption>
        </figure>
      </div>
    </div>
<hr class="rounded">
    <div class="row">
     
      <div class="col-sm-6">
        <h4>Station information</h4>
        <p>
          <b>The stations</b> display the local Downfall <b>in PLACEHOLDER</b> & temperature, and are updated <b>every second</b>. 
        </p>
        <hr />
        
      </div>
      <div class="col-sm-6">
        <figure>
          <img src="./images/measurements.png" alt="Three measurement visualisations" width="63%">
          <figcaption>
            left: wind direction | top-right: windspeed | bottom-right: temperature.
          </figcaption>
        </figure>
      </div>
    </div>
<hr class="rounded">
    <div class="row">
      
      <div class="col-sm-6">
        <h4>Table data</h4>
        <p>
          All stations save their data in <b>a table</b> which is visible on the station webpage. <b>You can download this table</b> in by clicking on the <b>Download Table</b> button.
          <hr/>
          The table does <b>not</b> automatically update, but you <b>can refresh the table</b> by clicking the <b>Refresh Table</b> button.
          <hr />
        </p>
      </div>
      <div class="col-sm-6">
        <figure>
          <img src="./images/table.png" alt="Data table" width="50%">
          <figcaption>
            To download or refresh the table, click the buttons outlined with blue rectangles
            <br />
            Note: South Atlantic stations display temperature & the Gambia stations windspeed and direction
          </figcaption>
        </figure>
      </div>
    </div>
<hr class="rounded">
    <div class="row">
      
        <div class="col-sm-6">
        <h4 style="padding-top: 15px;">Logging out</h4>
        <p>
          Clicking on <b>Log out</b> at the navigation bar will send you back to the login screen. You should <b>ALWAYS</b> before closing the application.
        </p>
      </div>
    </div>
  </div>
  <!--footer-->
   <footer> <small> &copy; Copyright <?php echo date("Y"); ?> Olam International All Rights Reserved Co. Reg. No. 199504676H </small> </footer>
  <!--Closing scripts for bootstrap-->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" 
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" 
    crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
    crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" 
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" 
    crossorigin="anonymous">
  </script>
</body>
</html>