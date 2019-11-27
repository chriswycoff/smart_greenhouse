<html>

<link rel = "stylesheet"
   type = "text/css"
   href = "interface.css" />

<meta http-equiv="refresh" content="20">

<title>Greenhouse Interface</title>
<H1>Welcome to the Greenhouse</H1> 
<br></br>


<?php

//connect to database
$con=mysqli_connect("localhost","name_of_user","password","name_of_database"));// server, user, pass, database

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//else{echo "connected";} // for debugging

//grab the table out of the database
$result = mysqli_query($con,"SELECT * FROM devices");//table select

while($row = mysqli_fetch_array($result)) {
	$fan = $row['fan'];
	$unit = $row['id'];
	$heat = $row['heat'];
	$temp = $row['temp'];
	$hum = $row['hum'];
	$water =$row['water'];
	$door =$row['door'];
	$override =$row['override'];
	$fan_timer_to_convert = $row['fan_timer'];

	$fan_timer_in_minutes = intval(($fan_timer_to_convert * 5 * (1/60)));

	if ($fan == "on"){
		$time_for_fan = 0;
	}
	else {
		$time_for_fan = 1440;
	}

		//fan logic
	if ($fan == "off"){
		$fan = "on";

		
		$fan_state = "off";
	}else{
		$fan = "off";
		
		$fan_state = "on";

	}

	// heater logic
	if ($heat == "off"){
		$heat = "on";

		
		$heat_state = "off";
	}else{
		$heat = "off";
		
		$heat_state = "on";

	}

	// water logic
	if ($water == "off"){
		$water = "on";

		
		$water_state = "off";
	}else{
		$water = "off";
		
		$water_state = "on";

	}

	// door logic
	if ($door == "closed"){
		$door = "open";

		
		$door_state = "closed";
	}else{
		$door = "closed";
		
		$door_state = "open";

	}



	$override = 'no';

	echo "<body>";

	
	echo "
		<form action=../../../green_house/real_greenhouse/change_data.php method='post'>
			<input type='hidden' name='unit' value=$unit >
			<input type='hidden' name='fan' value=$fan>
			<input type='hidden' name='fan_timer' value=$time_for_fan>
			<input type='hidden' name='pass' value=go>
			<input type='hidden' name='override' value=$override>
			<br> Fan is : <b> $fan_state </b> 
			<br> Time Left (minutes): $fan_timer_in_minutes 
			<br>
			Turn Fan : <input type='submit' value= $fan style='height:100px; width:100px'>
			<br>
		</form>";

	echo "
		<form action=../../../green_house/real_greenhouse/change_data.php method='post'>
			<input type='hidden' name='unit' value=$unit >
			<input type='hidden' name='heat' value=$heat>
			<input type='hidden' name='pass' value=go>
			<input type='hidden' name='override' value=$override>
			<br> Heater is : <b> $heat_state </b> 
			<br>
			Turn Heater : <input type='submit' value= $heat style='height:100px; width:100px'>
			<br>
		</form>";



	echo "
		<form action=../../../green_house/real_greenhouse/change_data.php method='post'>
			<input type='hidden' name='unit' value=$unit >
			<input type='hidden' name='water' value=$water>
			<input type='hidden' name='pass' value=go>
			<input type='hidden' name='override' value=$override>
			<br> Water is : <b> $water_state </b> 
			<br>
			Turn Water : <input type='submit' value= $water style='height:100px; width:100px'>
			<br>
		</form>";

	echo "
		<form action=../../../green_house/real_greenhouse/change_data.php method='post'>
			<input type='hidden' name='unit' value=$unit >
			<input type='hidden' name='door' value=$door>
			<input type='hidden' name='pass' value=go>
			<input type='hidden' name='override' value=$override>
			<br> Door is : <b> $door_state </b>
			<br>
			Change Door : <input type='submit' value= $door style='height:100px; width:100px'>
			<br>
		</form>";





}
echo "</body>";
	?>
