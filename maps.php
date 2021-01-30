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
    var markerGeolocation, markerBuenosAires, markerRiosGallegos,
      markerSantiago, markerLima, markerCaracas, markerSalvador, 
      markerBellaUnion;

    //initialize infoWindow variables
    var activeInfoWindow, infoWindowGeolocation, infoWindowBuenosAires, 
      infoWindowRiosGallegos, infoWindowSantiago, infoWindowLima, 
      infoWindowBogota, infoWindowCaracas, infoWindowSalvador,
      infoWindowBellaUnion;

    //initialize and set repeat strings for contentString variables
    var contentStringOpen    = '<div id="content"><h5>';
    var contentStringMiddle  = '</h5><a class="btn btn-primary" href="view_station.php?station=';
    var contentStringEnd     = '" role="button">Select this station</a></div>'

    //initialize and set contentString 
    var contentStringBellaUnion         = contentStringOpen + 'Bella Union'+
                                      contentStringMiddle + '863150' + contentStringEnd;
    //initialize and set contentString BuenosAires
    var contentBuenosAires       = contentStringOpen + 'Buenos Aires' +
                                      contentStringMiddle + '85940'  + contentStringEnd;
    //initialize and set contentString Rios Gallegos
    var contentStringRiosGallegos = contentStringOpen + 'Rios Gallegos' +
                                      contentStringMiddle + '619020' + contentStringEnd;
    //initialize and set contentString Santiago
    var contentStringSantiago = contentStringOpen + 'Santiago' +
                                      contentStringMiddle + '889030' + contentStringEnd;
    //initialize and set contentString Lima
    var contentStringLima = contentStringOpen + 'Lima' +
                                      contentStringMiddle + '888890' + contentStringEnd;
    //initialize and set contentString Bogota
    var contentStringBogota = contentStringOpen + 'Bogota' +
                                      contentStringMiddle + '888900' + contentStringEnd;
    //initialize and set contentString Caracas
    var contentStringCaracas = contentStringOpen + 'Caracas' +
                                      contentStringMiddle + '888910' + contentStringEnd;
    //initialize and set contentString Salvador
    var contentStringSalvador = contentStringOpen + 'Salvador' +
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
      
      //Uruguay
      var bellaunion      ={lat: -30.267, lng: -57.583};//863150
      var artigas         ={lat: -30.383, lng: -56.5};  //863300
      var rivera          ={lat: -30.883,lng: -55.533}; //863500
      var salto           ={lat: -31.383,lng: -57.95};  //863600
      var paysandu        ={lat:-32.333,lng: -58.033};  //864300
      var melo            ={lat:-32.366,lng: -54.183};  //864400
      var pasodelostoros  ={lat:-32.8,lng: -56.517};    //864600
      var mercedes        ={lat:-33.25,lng: -58.067};   //864900
      var treintaytres    ={lat:-33.217,lng: -54.383};  //865000
      var durazno         ={lat:-33.35,lng: -56.5};     //865300
      var florida         ={lat:-34.067,lng: -56.233};  //865450
      var colonia         ={lat:-34.45,lng: -57.833};   //865600
      var rocha           ={lat:-34.483,lng: -54.3};    //865650
      var melilla         ={lat:-34.783,lng: -56.25};   //865750
      var carrasco        ={lat:-34.833,lng: -56};      //865800
      var capitancorbetaca={lat:-34.85,lng: -55.083};   //865823
      var prado           ={lat:-34.85,lng: -56.2};     //865850
      var lagunadelsauce  ={lat:-34.867,lng: -55.1};    //865860

      //South America
      var buenosaires          = {lat: -34.605,   lng: -58.380};   // 85940
      var riosgallegos      = {lat: -51.623,   lng: -69.218};    // 619020
      var santiago          = {lat: -33.450,  lng: -70.668};    // 889030
      var lima              = {lat: -12.050,  lng: -77.051};   // 888890
      var bogota            = {lat: 4.711,    lng: -74.072};  // 888900
      var caracas           = {lat: 10.478,  lng: -66.904};  // 888910
      var salvador          = {lat: -12.979,   lng: -38.503};   // 689060

      //create map element
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: bellaunion 
      });

      /**THE FOLLOWING CODE CREATES THE MARKERS FOR THE MAP**/
      markerBellaUnion = new google.maps.Marker( {
        position: bellaunion,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Bella Union'
      })
      
      markerArtigas = new google.maps.Marker( {
        position: artigas,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Artigas'
      })
      markerRivera = new google.maps.Marker( {
        position: rivera,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Rivera'
      })
      markerSalto = new google.maps.Marker( {
        position: salto,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Salto'
      })
      markerPaysandu = new google.maps.Marker( {
        position: paysandu,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Paysandu'
      })
      markerMelo = new google.maps.Marker( {
        position: melo,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Melo'
      })
      markerPasodelOstoros = new google.maps.Marker( {
        position: pasodelostoros,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Paso del Ostoros'
      })
      markerMercedes = new google.maps.Marker( {
        position: mercedes,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Mercedes'
      })
      markerTreintaYTres = new google.maps.Marker( {
        position: treintaytres,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Treinta Y Tres'
      })
      markerDurazno = new google.maps.Marker( {
        position: durazno,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Durzano'
      })
      markerFlorida = new google.maps.Marker( {
        position: florida,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Florida'
      })
      markerColonia = new google.maps.Marker( {
        position: colonia,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Colonia'
      })
      markerRocha = new google.maps.Marker( {
        position: rocha,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Rocha'
      })
      markerMelilla = new google.maps.Marker( {
        position: melilla,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Melilla'
      })
      markerCarrasco = new google.maps.Marker( {
        position: carrasco,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Carrasco'
      })
      markerCaptainCorbetaca = new google.maps.Marker( {
        position: capitancorbetaca,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Captain Corbetaca'
      })
      markerPrado = new google.maps.Marker( {
        position: prado,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Prado'
      })
      markerLagunadelSauce = new google.maps.Marker( {
        position: lagunadelsauce,
        map: map,
        url: 'view_station.php?station=863150',
        title: 'Laguna del Sauce'
      })

      
      //place Buenos Aires marker 
      markerBuenosAires = new google.maps.Marker( {
        position: buenosaires,
        map: map,
        url: 'view_station.php?station=85940',
        title: 'SAL'
      });
      //Rios Gallegos marker
      markerRiosGallegos = new google.maps.Marker( {
        position: riosgallegos,
        map: map,
        url: 'view_station.php?station=619020',
        title: 'Rios Gallegos'
      });
      //Santiago marker  
      markerSantiago = new google.maps.Marker( {
        position: santiago,
        map: map,
        url: 'view_station.php?station=889030',
        title: 'Santiago'
      });
      //Lima marker 
      markerLima = new google.maps.Marker( {
        position: lima,
        map: map,
        url: 'view_station.php?station=888890',
        title: 'Lima'
      });
      //Bogota marker
      markerBogota = new google.maps.Marker( {
        position: bogota,
        map: map,
        url: 'view_station.php?station=888900',
        title: 'Bogota'
      });
      //Caracas marker
      markerCaracas = new google.maps.Marker( {
        position: caracas,
        map: map,
        url: 'view_station.php?station=888910',
        title: 'Caracas'
      });
      //Salvador marker
      markerSalvador = new google.maps.Marker( {
        position: salvador,
        map: map,
        url: 'view_station.php?station=689060',
        title: 'Salvador'
      });

      /**THE FOLLOWING CODE CREATES THE INFOWINDOWS FOR THE MARKERS**/
      //add infoWindows for all markers
      infoWindowBellaUnion = new google.maps.InfoWindow( {
        position: bellaunion,
        content: contentStringBellaUnion
      });
      infoWindowBuenosAires = new google.maps.InfoWindow( {
        position: buenosaires,
        content: contentBuenosAires
      });
      infoWindowRiosGallegos = new google.maps.InfoWindow( {
        position: riosgallegos,
        content: contentStringRiosGallegos
      });
      infoWindowSantiago = new google.maps.InfoWindow( {
        position: santiago,
        content: contentStringSantiago
      });
      infoWindowLima = new google.maps.InfoWindow( {
        position: lima,
        content: contentStringLima
      });
      infoWindowBogota = new google.maps.InfoWindow( {
        position: bogota,
        content: contentStringBogota
      });
      infoWindowCaracas = new google.maps.InfoWindow( {
        position: caracas,
        content: contentStringCaracas
      });
      infoWindowSalvador = new google.maps.InfoWindow( {
        position: salvador,
        content: contentStringSalvador
      });

      //add mouse click listeners for every marker
      markerBellaUnion.addListener('click', function() {
        clickEvent(map, infoWindowBellaUnion);
      });
      markerBuenosAires.addListener('click', function() {
        clickEvent(map, infoWindowBuenosAires);
      });
      markerRiosGallegos.addListener('click', function() {
        clickEvent(map, infoWindowRiosGallegos);
      });
      markerSantiago.addListener('click', function() {
        clickEvent(map, infoWindowSantiago);
      });
      markerLima.addListener('click', function() {
        clickEvent(map, infoWindowLima);
      });
      markerBogota.addListener('click', function() {
        clickEvent(map, infoWindowBogota);
      });
      markerCaracas.addListener('click', function() {
        clickEvent(map, infoWindowCaracas);
      });
      markerSalvador.addListener('click', function() {
        clickEvent(map, infoWindowSalvador);
      });

      /* These listeners are made for ease of use.
       * Double clicking a weather station marker takes
       * you straight to its graph data, instead of having
       * to press the 'select station' button
       */
      //add double click listeners for all markers
      markerBellaUnion.addListener('dbclick', function() {
        clickEvent(map, infoWindowBellaUnion);
      });
      markerBuenosAires.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      markerRiosGallegos.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      markerSantiago.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      markerLima.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      markerBogota.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      markerCaracas.addListener('dblclick', function() {
        window.location.href = this.url;
      });
      markerSalvador.addListener('dblclick', function() {
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
      activeInfoWindow = infoWindowBellaUnion;
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
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjwCaVgOh0wgk15tAVeIqk51V3oUHi9tQ&callback=initMap">
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