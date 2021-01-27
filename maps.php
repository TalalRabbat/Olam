<?php
  include 'functions.php';

  /*This code checks if the user is logged in*/
  session_start();
  check_login();
?>
<!--Initiate webpage-->
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

  <!--Bootstrap makeup for the website-->
  <style>
    html,
    /*set style for body*/
    body {
      height: 100%;
      background-color: #f5f5f5;
      margin: 0;
      overflow-y: hidden;
    }
    /*set style for map*/
    #map {
      height: 89%;  
      width: 100%; 
    }

    /*set style for navigation bar*/
    .navbar {
      min-height: 10%;
    }
    /*set style for navigation bar*/
    .navbar-brand {
      padding: 0 15px;
      height: 10%;
      line-height: 80px;
    }

    /*set style for footer*/
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

    }
  </style>
</head>
<!--Website body-->
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
          <li class="nav-item active">
            <a class="nav-link" href="maps.php">Stations</a>
          </li>
          <li class="nav-item">
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

</header>

<br/>
<br/>
  <!--The divider for the map -->
  <div id="map"></div>
  <!--Script to get the map on the webpage-->
  <script>
    //initialize variable map
    var map;

    //initialize marker variables
    var markerGeolocation, markerGambia, markerAtlantic, markerSouthAtlantic1,
      markerSouthAtlantic2, markerSouthAtlantic3, markerSouthAtlantic5, markerSouthAtlantic6;

    //initialize infoWindow variables
    var activeInfoWindow, infoWindowGeolocation, infoWindowGambia, infoWindowAtlantic, 
      infoWindowSouthAtlantic1, infoWindowSouthAtlantic2, infoWindowSouthAtlantic3, 
      infoWindowSouthAtlantic4, infoWindowSouthAtlantic5, infoWindowSouthAtlantic6;

    //initialize and set repeat strings for contentString variables
    var contentStringOpen    = '<div id="content"><h5>';
    var contentStringMiddle  = '</h5><a class="btn btn-primary" href="view_station.php?station=';
    var contentStringEnd     = '" role="button">Select this station</a></div>'

    //initialize and set contentString Gambia station
    var contentStringGambia         = contentStringOpen + 'BANJUL/YUNDUM'+
                                      contentStringMiddle + '617010' + contentStringEnd;
    //initialize and set contentString Atlantic station
    var contentStringAtlantic       = contentStringOpen + 'SAL' +
                                      contentStringMiddle + '85940'  + contentStringEnd;
    //initialize and set contentString South Atlantic station 1
    var contentStringSouthAtlantic1 = contentStringOpen + 'WIDE AWAKE FIELD' +
                                      contentStringMiddle + '619020' + contentStringEnd;
    //initialize and set contentString South Atlantic station 2
    var contentStringSouthAtlantic2 = contentStringOpen + 'GRYTVIKEN S.GEORGIA' +
                                      contentStringMiddle + '889030' + contentStringEnd;
    //initialize and set contentString South Atlantic station 3
    var contentStringSouthAtlantic3 = contentStringOpen + 'MOUNT PLEASANT AIRP' +
                                      contentStringMiddle + '888890' + contentStringEnd;
    //initialize and set contentString South Atlantic station 4
    var contentStringSouthAtlantic4 = contentStringOpen + 'STANLEY' +
                                      contentStringMiddle + '888900' + contentStringEnd;
    //initialize and set contentString South Atlantic station 5
    var contentStringSouthAtlantic5 = contentStringOpen + 'STANLEY AIRPORT' +
                                      contentStringMiddle + '888910' + contentStringEnd;
    //initialize and set contentString South Atlantic station 6
    var contentStringSouthAtlantic6 = contentStringOpen + 'GOUGH ISLAND' +
                                      contentStringMiddle + '689060' + contentStringEnd;

    /* This function closes the current infoWindow and opens a new one
     *
     * map:           The map in use
     * info_window:   Corresponding infoWindow of clicked marker
     */
    function clickEvent(map, info_window) {
      activeInfoWindow.close(map);
      activeInfoWindow = info_window;
      activeInfoWindow.open(map);
    }

    //this function initiates the map
    function initMap() {
      //initialize coordinate variables for the weather stations and geolocation
      var pos_geolocation;                                   
      var gambia                  = {lat: 13.2,     lng: -16.633};  // 617010
      var atlantic                = {lat: 16.733,   lng: -22.95};   // 85940
      var south_atlantic_ocean_1  = {lat: -7.967,   lng: -14.4};    // 619020
      var south_atlantic_ocean_2  = {lat: -54.267,  lng: -36.5};    // 889030
      var south_atlantic_ocean_3  = {lat: -51.817,  lng: -58.45};   // 888890
      var south_atlantic_ocean_4  = {lat: -51.7,    lng: -57.867};  // 888900
      var south_atlantic_ocean_5  = {lat: -51.683,  lng: -57.767};  // 888910
      var south_atlantic_ocean_6  = {lat: -40.35,   lng: -9.883};   // 689060

      //create map element
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: gambia 
      });

      /**THE FOLLOWING CODE CREATES THE MARKERS FOR THE MAP**/
      //place Gambia marker on map
      markerGambia = new google.maps.Marker( {
        position: gambia,
        map: map,
        url: 'view_station.php?station=617010',
        title: 'BANJUL/YUNDUM'
      })
      //place Atlantic marker on map 
      markerAtlantic = new google.maps.Marker( {
        position: atlantic,
        map: map,
        url: 'view_station.php?station=85940',
        title: 'SAL'
      });
      //place South Atlantic 1 marker on map 
      markerSouthAtlantic1 = new google.maps.Marker( {
        position: south_atlantic_ocean_1,
        map: map,
        url: 'view_station.php?station=619020',
        title: 'WIDE AWAKE FIELD'
      });
      //place South Atlantic 2 marker on map 
      markerSouthAtlantic2 = new google.maps.Marker( {
        position: south_atlantic_ocean_2,
        map: map,
        url: 'view_station.php?station=889030',
        title: 'GRYTVIKEN S.GEORGIA'
      });
      //place South Atlantic 3 marker on map 
      markerSouthAtlantic3 = new google.maps.Marker( {
        position: south_atlantic_ocean_3,
        map: map,
        url: 'view_station.php?station=888890',
        title: 'MOUNT PLEASANT AIRP'
      });
      //place South Atlantic 4 marker on map 
      markerSouthAtlantic4 = new google.maps.Marker( {
        position: south_atlantic_ocean_4,
        map: map,
        url: 'view_station.php?station=888900',
        title: 'STANLEY'
      });
      //place South Atlantic 5 marker on map 
      markerSouthAtlantic5 = new google.maps.Marker( {
        position: south_atlantic_ocean_5,
        map: map,
        url: 'view_station.php?station=888910',
        title: 'STANLY AIRPORT'
      });
      //place South Atlantic 6 marker on map 
      markerSouthAtlantic6 = new google.maps.Marker( {
        position: south_atlantic_ocean_6,
        map: map,
        url: 'view_station.php?station=689060',
        title: 'GOUGH ISLAND'
      });

      /**THE FOLLOWING CODE CREATES THE INFOWINDOWS FOR THE MARKERS**/
      //add infoWindow for Gambia station marker
      infoWindowGambia = new google.maps.InfoWindow( {
        position: gambia,
        content: contentStringGambia
      });
      //add infoWindow for Atlantic station marker
      infoWindowAtlantic = new google.maps.InfoWindow( {
        position: atlantic,
        content: contentStringAtlantic
      });
      //add infoWindow for South Atlantic 1 station marker
      infoWindowSouthAtlantic1 = new google.maps.InfoWindow( {
        position: south_atlantic_ocean_1,
        content: contentStringSouthAtlantic1
      });
      //add infoWindow for South Atlantic 2 station marker
      infoWindowSouthAtlantic2 = new google.maps.InfoWindow( {
        position: south_atlantic_ocean_2,
        content: contentStringSouthAtlantic2
      });
      //add infoWindow for South Atlantic 3 station marker
      infoWindowSouthAtlantic3 = new google.maps.InfoWindow( {
        position: south_atlantic_ocean_3,
        content: contentStringSouthAtlantic3
      });
      //add infoWindow for South Atlantic 4 station marker
      infoWindowSouthAtlantic4 = new google.maps.InfoWindow( {
        position: south_atlantic_ocean_4,
        content: contentStringSouthAtlantic4
      });
      //add infoWindow for South Atlantic 5 station marker
      infoWindowSouthAtlantic5 = new google.maps.InfoWindow( {
        position: south_atlantic_ocean_5,
        content: contentStringSouthAtlantic5
      });
      //add infoWindow for South Atlantic 6 station marker
      infoWindowSouthAtlantic6 = new google.maps.InfoWindow( {
        position: south_atlantic_ocean_6,
        content: contentStringSouthAtlantic6
      });

      //add mouse click Listener for Gambia marker
      markerGambia.addListener('click', function() {
        clickEvent(map, infoWindowGambia);
      });
      //add mouse click Listener for Atlantic marker
      markerAtlantic.addListener('click', function() {
        clickEvent(map, infoWindowAtlantic);
      });
      //add mouse click Listener for South Atlantic marker 1
      markerSouthAtlantic1.addListener('click', function() {
        clickEvent(map, infoWindowSouthAtlantic1);
      });
      //add mouse click Listener for South Atlantic marker 2
      markerSouthAtlantic2.addListener('click', function() {
        clickEvent(map, infoWindowSouthAtlantic2);
      });
      //add mouse click Listener for South Atlantic marker 3
      markerSouthAtlantic3.addListener('click', function() {
        clickEvent(map, infoWindowSouthAtlantic3);
      });
      //add mouse click Listener for South Atlantic marker 4
      markerSouthAtlantic4.addListener('click', function() {
        clickEvent(map, infoWindowSouthAtlantic4);
      });
      //add mouse click Listener for South Atlantic marker 5
      markerSouthAtlantic5.addListener('click', function() {
        clickEvent(map, infoWindowSouthAtlantic5);
      });
      //add mouse click Listener for South Atlantic marker 6
      markerSouthAtlantic6.addListener('click', function() {
        clickEvent(map, infoWindowSouthAtlantic6);
      });

      /* These listeners are made for ease of use.
       * Double clicking a weather station marker takes
       * you straight to its graph data, instead of having
       * to press the 'select station' button
       */
      //add double click listener for Gambia marker
      markerGambia.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      //add double click Listener for Atlantic marker
      markerAtlantic.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      //add double click Listener for South Atlantic marker 1
      markerSouthAtlantic1.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      //add double click Listener for South Atlantic marker 2
      markerSouthAtlantic2.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      //add double click Listener for South Atlantic marker 3
      markerSouthAtlantic3.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      //add double click Listener for South Atlantic marker 4
      markerSouthAtlantic4.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      //add double click Listener for South Atlantic marker 5
      markerSouthAtlantic5.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      //add double click Listener for South Atlantic marker 6
      markerSouthAtlantic6.addListener('dblclick', function() {
        window.location.href = this.url;
      });

      /* This big if-else statement is used for geolocation.
       * If you allow access for geolocation, this code will create
       * a custom marker, infoWindow and click Listener for your current location
       */
      //check for access to geolocation
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          //format coordinates such that google maps API can read it, and save it in a variable
          pos_geolocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          //place geolocation marker on map 
          markerGeolocation = new google.maps.Marker( {
            position: pos_geolocation,
            map: map,
            title: 'Your current location',
            icon: {
              url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"    //Custom marker icon to distinguish from stations
            }
          });
          //create infoWindow for geolocation marker
          infoWindowGeolocation = new google.maps.InfoWindow( {
            position: pos_geolocation,
            content: 'Your current location'
          });
          //add mouse click Listener to geolocation marker
          markerGeolocation.addListener('click', function() {
            clickEvent(map, infoWindowGeolocation);
          });
        }, 
        //browser supports geolocation, but an error still occurred
        function() {
          handleLocationError(true, infoWindowGeolocation, map.getCenter());
        });
      } else {
        //browser doesn't support geolocation
        handleLocationError(false, infoWindowGeolocation, map.getCenter());
      }
      //Gambia infoWindow link to activeInfoWindow
      activeInfoWindow = infoWindowGambia;
    }
    // This function handles errors for geolocation
    function handleLocationError(browserHasGeolocation, infoWindowGeolocation, pos_geolocation) {
      infoWindowGeolocation.setPosition(pos_geolocation);
      infoWindowGeolocation.setContent(browserHasGeolocation ?
         'Error: The Geolocation service failed.' :
         'Error: Your browser doesn\'t support geolocation.');
      infoWindowGeolocation.open(map);
    }
  </script>
  <!--Load the API from the specified URL
  * The async attribute allows the browser to render the page while the API loads
  * The key parameter will contain your own API key (which is not needed for this tutorial)
  * The callback parameter executes the initMap() function-->
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDupy91HDLCEYrvsBj32obYqZhbFmg5dPg&callback=initMap">
  </script>
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