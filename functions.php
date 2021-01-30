<?php
	// Set username and password
	$USER_USERNAME = "user";
	$USER_PASSWORD = '$argon2i$v=19$m=1024,t=2,p=2$RGVNME4weFFwMmMyd01IZw$a28OeXYplLovOamT/0VITKf3kMsWi+mQVMJjAVKlxcw';

	// Array of the stations used for this project
	$allowed_stations = array("863150" => "Bella Union", "617010" => "Monte Video", "85940" => "Buenos Aires", "619020" => "Rios Gallegos", "889030" => "Santiago", "888890" => "Lima", "888900" => "Bogota", "888910" => "Caracas", "689060" => "Salvador");
	$stations_temp = array(889030, 888890, 888900, 888910, 689060, 619020);
	$stations_wind = array(617010, 85940);
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
	 * is one of the stations that needs temperature measurements
	 */
	function check_temp_station($station){
		global $stations_temp;
		if(in_array($station, $stations_temp)) {
			return true;
		} else {
			return false;
		}
	}
	/* This function checks if the selected weather station
	 * is one of the stations that needs wind measurements
	 */
	function check_wind_station($station){
		global $stations_wind;
		if(in_array($station, $stations_wind)) {
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
	 
	function parse_bin($bin_file,$name){
		global $measurements;
		//if file doesnt exist: clear measurements
		if(! file_exists($bin_file)){
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
			fread($file,11);
			$wdsp=unpack("c",fread($file,1))[1];
			$wdsp_remainder=unpack("c",fread($file,1))[1]; 
			fread($file,7);
			$wnddir=unpack("s",fread($file,2))[1];
			
			
			$measurement =new Measurement(); 
            $measurement->stn=intval($name);
 		 	$measurement->date_and_time=date_create("$year-$month-$day $hours:$minutes:$seconds");
	        $measurement->temp=parse_to_float($temperature,$temperature_remainder);
	        $measurement->wdsp=parse_to_float($wdsp,$wdsp_remainder);
	        $measurement->wnddir=$wnddir;
	        $measurements=array_merge($measurements,array($measurement));  

		
			

			
			
			
		}
		fclose($file);
	}

	/* This function reads wind direction
	 * and converts it to a direction in words, like north east
	 */
	function wnddir_to_words($wnddir){
		if($wnddir>=340 || $wnddir<=20){
			return "NORTH";
		}
		elseif(in_array($wnddir,range(70,110))){
			return "EAST";
		}
		elseif(in_array($wnddir,range(160,200))){
			return "SOUTH";
		}
		elseif(in_array($wnddir,range(250,290))){
			return "WEST";
		}
		elseif(in_array($wnddir,range(21,69))){
			return "NORTH-EAST";
		}
		elseif(in_array($wnddir,range(111,159))){
			return "SOUTH-EAST";
		}
		elseif(in_array($wnddir,range(201,249))){
			return "SOUTH-WEST";
		} 
		else{
			return "NORTH-WEST";
		}
	}
	function createCompass($degrees){
		$degrees=-1*$degrees;
	header("Content-type: image/png");
	$img_width = 701;
	$img_height = 701;
	$dest_image = imagecreatetruecolor($img_width, $img_height);
	$a = imagecreatefrompng("image.png");
	$b = imagecreatefrompng("arrow.png");
	$c = imagecreatefrompng("sides.png");
	$source = $b;
	$sw = imagesx($source);
	$sh = imagesy($source);

	$rotate = imagerotate($source, $degrees, 0);
	$rw = imagesx($rotate);
	$rh = imagesy($rotate);
		
	$croppedarrow = imagecrop($rotate, array(
		'x' => $rw * (1 - $sw / $rw) * 0.5,
		'y' => $rh * (1 - $sh / $rh) * 0.5,
		'width' => $sw,
		'height'=> $sh
	));

	imagecopy($dest_image, $a, 0, 0, 0, 0, $img_width, $img_height);
	imagecopy($dest_image, $croppedarrow, 0, 0, 0, 0, $img_width, $img_height);
	imagecopy($dest_image, $c, 0, 0, 0, 0, $img_width, $img_height);

	header('Content-Type: image/png');
	imagepng($dest_image,"compass.png");
   }

	
	
	
	
?>
