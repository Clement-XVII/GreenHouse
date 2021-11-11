<?php
include "connex.php"
// Create connection
$connexion = mysqli_connect($host, $user, $pass, $database);
// Check connection
if (!$connexion) {
  die("Connection failed: " . mysqli_connect_error());
}

//$sql = "INSERT INTO test.sensor (value) VALUES ('".$_GET["value"]."')";    
$sql = "INSERT INTO sensor (temp, hum, hc) VALUES (('".$_GET["temp"]."'), ('".$_GET["hum"]."'), ('".$_GET["hc"]."'))"; 

    // Execute SQL statement

    if (mysqli_query($connexion, $sql)) {
  		echo "New record created successfully";
	} 
	else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($connexion);
	}

	mysqli_close($connexion);
?>
