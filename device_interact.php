<?php

// Change lines 26, 31 (maybe more) to meet your specific credentials, 
// change database logic to meet your specific sql database configuration

//loop through and grab variables off the URL
foreach($_REQUEST as $key => $value){
	if($key =="unit"){
	$unit = $value;
	    
	}
	if($key =="hum"){
	    $hum = $value;
	    
	}     
	if($key =="temp"){
		$temp = $value;
     
	}
	if($key =="pass"){
		$pass = $value;
     
	}

}//for each

if ($pass != "the pass from esp8266.ino file"){
	exit("invalid acess");
}

// Create connection to SQL database
$con=mysqli_connect("localhost","name_of_user","password","name_of_database");// server, user, pass, database

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//else{echo "connected";}
    
    //echo "led on";
//update sensor value in database
mysqli_query($con,"UPDATE devices SET temp = $temp WHERE id=$unit");

mysqli_query($con,"UPDATE devices SET hum = $hum WHERE id=$unit");


//if we need to get the time from the internet, use this.  This sets teh timezone
date_default_timezone_set('America/Los_Angeles');
$time = date("gi");//many different possible formats, but this gives 12 hr format, and returns 1:23 as 123

//pull out the table
$result = mysqli_query($con,"SELECT * FROM devices");//table select

//loop through the table and filter out data for this unit id
while($row = mysqli_fetch_array($result)) {
	if($row['id'] == $unit){
	$temp = $row['temp'];
	$hum = $row['hum'];
	$fan = $row['fan'];
	$heat =$row['heat'];
	$water =$row['water'];
	$door =$row['door'];
	$fan_timer =$row['fan_timer'];

	if ($fan == "off"){
		$fan_timer = 0;
	}

	if (($fan_timer) > 0){
		$fan_timer = ($fan_timer - 1);
	}
	

	mysqli_query($con,"UPDATE devices SET fan_timer = $fan_timer WHERE id=$unit");

	if (($fan_timer) <= 0){
		mysqli_query($con,"UPDATE devices SET fan = 'off' WHERE id=$unit");

	}



		if ($fan == "off"){
		             echo "fan=0 ";
		             }else{
		             echo "fan=1 ";
		             }

		if ($heat == "off"){
		             echo "heat=0 ";
		             }else{
		             echo "heat=1 ";
		             }

		if ($water == "off"){
		             echo "water=0 ";
		             }else{
		             echo "water=1 ";
		             }

		if ($door == "closed"){
		             echo "door=0 ";
		             }else{
		             echo "door=1 ";
		             }


		}

                
}



?>

