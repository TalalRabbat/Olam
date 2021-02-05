<?php
	include 'functions.php';

	/*This code checks if the user is logged in*/
	session_start();
	check_login();
	$station_id=617010;

	if(check_station($station_id)) {
		$error_message = false;
	} else {
		$error_message = true;
	}
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

  	.mask{
  		margin-top: 100px;
  	}
  	table{   
	border-spacing: 0;
	border-collapse:collapse;
	text-align: center;
	color: #7D7D7D;
	}	
	tbody, thead tr { display: block; }	
	tbody {
    height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
	}
	th{
    border:0px solid black;
	width: 10%;
	}
	tr{
    border:1px solid black;
	}
	td{
    width: 10%;
    border:1px solid black;
	}
	/*Made to center fish*/
	.center {
	display: block;
	margin-left: auto;
	margin-right: auto;
	width: 100%;
	}
	/* Rounded border */
	hr.rounded {
  		border-top: 8px solid #bbb;
 	 	border-radius: 5px;
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
				<li class="nav-item active">
					<a class="nav-link" aria-current="page" href="home.php">Home</a>
				</li>
				<li class="nav-item">
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

<!-- Background image -->
<div
    class="p-5 text-center bg-image"
    style="
      background-image: url('./images/banner.jpg');
      height: 400px;
      margin-top: 58px;
      box-shadow:inset 0 0 0 2000px rgba(0,0,0,0.5);
	">
	
	<div class="mask">
    	<div class="d-flex justify-content-center align-items-center h-100">
    		<div class="text-white">
          		<h1 class="mb-3">Welcome to the Olam Weather Application!</h1>
				<!-- 
		  		<h4 class="mb-3"><strong> Write here more informetion about this site.....</strong> </h4>
				-->		
			</div>
      	</div>
    </div>
</div>  
</header>

<br/>
<br/>
<!--Code that checks if error message needs to be displayed-->
<?php
	if($error_message) {
	echo '<div class="alert alert-danger" role="alert" style="margin-top: 30px;">
	<b>ERROR: </b>Selected weather station is not available for this application. <a href="home.php" class="alert-link">Go back to the homepage.</a>
	</div>';
	}
?>

<div class="container">
    <div class="row">
		<div class="col-sm-8" style="display:inline-block; width: 100%; color:#7D7D7D;">
			<a id="data_table"  class="wtable"></a>
		</div>
	</div>
	<hr class="rounded">
	<div class="row">
		<div class="col-sm-12">
	  		<!--Canvas here-->
	  		<canvas id="canvas" style=""></canvas>
    	</div>
    </div>
</div>

<script>
	var pause_status = false;
	//Interval for showtemp function
	window.setInterval(checkTable, 1000);
	function checkTable(){
		if(pause_status == false){
			ReadCSV();
			showTable();
			showtempTable();
			showWdsp(); 
			removeData(window.myLine);
			}
		else{
			ReadXML();
			showWdsp(); 
			removeData(window.myLine);
		}
	}
	function pauseTable(){
		pause_status = true;
	}
	function continueTable(){
		pause_status = false;
	}
</script>




<script>
  	parser = new DOMParser();

	var getParam="?station=617010";
	//set configuration variable
	var config = {
		//Set graph as linegraph
		type: 'line',
		//Graph data information
		data:{
			labels: [],
			datasets: [{
				label: 'Downfall',
				data: [],
				fill: false,
			}]
		},
	  	//Graph options
		options: {
			//responsiveness
			responsive: true,
			title: {
				display: true,
				text: 'Downfall'
			},
			//tooltip
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			//mouse hover
			hover: {
				mode: 'nearest',
				intersect: true
			},
			//scaling
	    	scales: {
	      		//scaling x-axis
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: 'Time'
					}
				}],
				//scaling y-axis
				yAxes: [{
					scaleLabel: {
						display: true,
						labelString: 'Downfall',
					}
	      		}]
			}
	  	}
	};

	//Load data onto graph
	window.onload = function() {
	  	var ctx = document.getElementById('canvas').getContext('2d');
	  	window.myLine = new Chart(ctx, config);
	};

	//Add data
	function addData(chart, label, data) {
	  	chart.data.labels.push(label);
	  	chart.data.datasets.forEach((dataset) => {
	    	dataset.data.push(data);
	  	});
	  	chart.update();
	}

	//Remove first datapoint after two minutes
	function removeData(chart) {
      	if(Object.keys(window.myLine.data.datasets[0].data).length == 120) {
			chart.data.labels.shift();
			chart.data.datasets.forEach((dataset) => { dataset.data.shift();	});
	    	chart.update();
		}
	}

	//function to show temperature
	function showTemp() {
	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	      	if (this.readyState == 4 && this.status == 200) 
          	addData(window.myLine, '', this.responseText);
	    document.getElementById("current_temperature").innerHTML = this.responseText;
	  	}
	  	xmlhttp.open("GET", "ajax_temperature.php"+getParam, true);
	  	xmlhttp.send();
	}

    //function to show wind speed
	function showWdsp() {
	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	      if (this.readyState == 4 && this.status == 200) 
	      	var today = new Date();
			var time = today.getHours() + ":" + today.getMinutes();
          	addData(window.myLine, time, this.responseText);
	    }
	  	xmlhttp.open("GET", "ajax_precipitation.php"+getParam, true);
	  	xmlhttp.send();
	}

	//function to show table with weatherdata
	function showTable(){
	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	      	if (this.readyState == 4 && this.status == 200) {
			document.getElementById("data_table").innerHTML = this.responseText;
	    	}
	  	}
	  	xmlhttp.open("GET", "ajax_table.php"+getParam, true);
	  	xmlhttp.send();
	}
	function showtempTable(){
	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	      	if (this.readyState == 4 && this.status == 200) {
			document.getElementById("date_temp_table").innerHTML = this.responseText;
	    	}
	  	}
	 	xmlhttp.open("GET", "ajax_table_temp.php"+getParam, true);
	  	xmlhttp.send();
	}
	
	//This function reads the needed csv files once
	function ReadCSV(){
	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	      	if (this.readyState == 4 && this.status == 200) {
		
	    	}
	  	}
	  	xmlhttp.open("GET", "ajax_parse_dir.php"+getParam, true);
	  	xmlhttp.send();
	}	
</script>
  
<script src="jquery.min.1.11.1.js" type="text/javascript"></script>  
<script src="jquery.tabletoxml.js" type="text/javascript"></script>  
<script type="text/javascript">  
    function exporttoxml(table) {  
		$(table).tabletoxml({  
			rootnode: "Data",  
			childnode: "Measurement",  
			filename: "<?php echo get_station_name($station_id); ?>" + table.substr(1)				
		});  
	}  

</script>
</div>
	<footer> <small> &copy; Copyright <?php echo date("Y"); ?> Olam International All Rights Reserved Co. Reg. No. 199504676H </small> </footer>

	<script source="https://code.jquery.com/jquery-3.4.1.slim.min.js" 
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