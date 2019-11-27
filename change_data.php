<?php


/* CREATED BY Chris Wycoff see chriswycoff.com for more details on the author */

//change lines 21, 28, 80 (maybe more) to meet your specific credentilas
// change database logic to meet your specific sql database configuration

//get the post variables

$override = $_POST['override'];
$unit = $_POST['unit'];
$temp = $_POST['temp'];
$hum = $_POST['hum'];
$fan = $_POST['fan'];
$heat = $_POST['heat'];
$water = $_POST['water'];
$pass = $_POST['pass'];
$door = $_POST['door'];
$fan_timer =$_POST['fan_timer'];

if ($pass != "the pass from esp8266.ino file"){
	exit("invalid acess");
}


//connect to the database
echo 'hi' . $fan. $unit;
$con=mysqli_connect("localhost","name_of_user","password","name_of_database"));// server, user, pass, database

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//update the value

if ($override == 'yes'){
	mysqli_query($con,"UPDATE devices SET override = 'yes'
WHERE id=$unit");
}
else{
	mysqli_query($con,"UPDATE devices SET override = 'no'
WHERE id=$unit");

}


if (!empty($fan)){
mysqli_query($con,"UPDATE devices SET fan = '{$fan}'
WHERE id=$unit");
mysqli_query($con,"UPDATE devices SET fan_timer = '{$fan_timer}'
WHERE id=$unit");
echo "changed" . $fan;
echo $fan;
}

if (!empty($heat)){
mysqli_query($con,"UPDATE devices SET heat = '{$heat}'
WHERE id=$unit");
echo "changed" . $heat;
echo $heat;
}

if (!empty($water)){
mysqli_query($con,"UPDATE devices SET water = '{$water}'
WHERE id=$unit");
echo "changed" . $water;
echo $water;
}

if (!empty($door)){
mysqli_query($con,"UPDATE devices SET door = '{$door}'
WHERE id=$unit");
echo "changed" . $door;
echo $door;
}



//go back to the interface
header("location: ../../ WHEREVER YOUR greenhouse_interface.php IS");

    ?>
