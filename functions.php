<?php
	// Set username and password
	$USER_USERNAME = "user";
	$USER_PASSWORD = '$argon2i$v=19$m=1024,t=2,p=2$RGVNME4weFFwMmMyd01IZw$a28OeXYplLovOamT/0VITKf3kMsWi+mQVMJjAVKlxcw';

	// Array of the stations used for this project
	$allowed_stations = array("863150" => "Bella Union", "863300" => "Artigas", "617010" => "Monte Video", "85940" => "Buenos Aires", "619020" => "Rios Gallegos", "889030" => "Santiago", "888890" => "Lima", "888900" => "Bogota", "888910" => "Caracas", "689060" => "Salvador",
								"863500" => "Rivera","863600" => "Salto","864300" => "Paysandu","864400" => "Melo","864600" => "Paso del Ostoros","864900" => "Mercedes","865000" => "Treinta y Tres","865300" => "Durazno","865450" => "Florida","865600" => "Colonia","865650" => "Rocha",
								"865750" => "Melilla", "865800" => "Carrasco","865823" => "Capitan Corbetaca","865850" => "Prado","865860" => "Laguna del Sauce",);
	$stations_temp = array(889030, 888890, 888900, 888910, 689060, 619020, 617010, 85940, 863300);
	$stations_prcp = array(889030, 888890, 888900, 888910, 689060, 619020, 617010, 85940, 863300);
	/* This function compares username and password credentials
	 * and checks if the input is correct
	 */
	function verify_login($username, $password) {
		global $USER_USERNAME, $USER_PASSWORD; 
		if(password_verify($password, $USER_PASSWORD) == 1 && $username == $USER_USERNAME) {
			return true;
		}
		else{
			return true;
		}
	}
	
	/* This function checks if a login
	 * session is active, if it is not, redirect to login screen
	 */
	function check_login() {
		if(!isset($_SESSION['logged_in'])) {
			header('location: index.php');
		}
	}

	/* This function checks if the selected weather station
	 * is one of the stations used for this project
	 */
	function check_station($station) {
		global $allowed_stations;
		if(array_key_exists($station, $allowed_stations)) {
			return true;
		} else {
			return false;
		}
	}

	/* This function checks if the selected weather station
	 * is one of the stations that needs a form of measurement
	 */
	function check_temp_station($station){
		global $stations_temp;
		if(in_array($station, $stations_temp)) {
			return true;
		} else {
			return false;
		}
	}
	function check_precipitation_station($station){
		global $stations_prcp;
		if(in_array($station, $stations_prcp)) {
			return true;
		} else {
			return false;
		}
	}

	/* This function returns the name of a station. It uses the key of
	 * the $allowed_stations array to search the $station_locations array
	 */
	function get_station_name($station) {
		global $allowed_stations;

		$name = $allowed_stations[$station];

		return $name;
	}

	/* This array will hold the required data for the weather application, 
	 * in the form of a measurement object
	 * The key is the stationnumber, the value is an array of the measurement objects belonging to the 
	 * station, holding this stationnumber.
	 */
	$measurements=array();

	/* This class creates a measurement object,
	 * which holds data of a measuremnt in a weatherstation
	 */
	class Measurement{
	    public $stn;
	    public $date_and_time;
	    public $temp;
	    public $wdsp;
	    public $wnddir; 
	}

	//This functions takes two numbers and adds them together where 1 number will be calculated the remainder
	function parse_to_float($num,$remainder){
		if($num<0){
			return $num-($remainder/10);
		} else{
			return $num+($remainder/10);
		}
	}
	
	/* This function parses an bin file and filters based on the stationnumber
	 * If the stationnumber belongs to a station that is needed an object will be created 
	 * The object will be put in the measurements array
	 */
	 
	function parse_bin($bin_file, $name){
		global $measurements;
		//if file doesnt exist: clear measurements
		if(!file_exists($bin_file)){
			$measurements=array();
			return;
		}
		
		$file=fopen($bin_file, "rb");		
		
		while(!feof($file)){
			if((ftell($file))==filesize($bin_file)){
				break;
			}
						
			$year=unpack("s",fread($file,2))[1];
			$month=unpack("c",fread($file,1))[1];
			$day=unpack("c",fread($file,1))[1];	
			$hours=unpack("c",fread($file,1))[1];
			$minutes=unpack("c",fread($file,1))[1];
			$seconds=unpack("c",fread($file,1))[1];

			$temperature=unpack("c",fread($file,1))[1];
			$temperature_remainder=unpack("c",fread($file,1))[1];
			fread($file,20);
			
			$prcp=unpack("c",fread($file,1))[1];
			$prcp_remainder=unpack("c",fread($file,1))[1]; 	
			
			$measurement =new Measurement(); 
            $measurement->stn=intval($name);
 		 	$measurement->date_and_time=date_create("$year-$month-$day $hours:$minutes:$seconds");
	        $measurement->temp=parse_to_float($temperature,$temperature_remainder);
			$measurement->prcp=parse_to_float($prcp, $prcp_remainder);
			
	        
	        $measurements=array_merge($measurements,array($measurement));  
				
		}

		fclose($file);
	}
?>
