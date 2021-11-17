<?php
if(isset($_GET["temp"])) {
   $temperature = $_GET["temp"]; // get temperature value from HTTP GET
   $humidity = $_GET["hum"];
   $hc = $_GET["hc"];
   $humiditesol = $_GET["humsol"];
   $sondetemp = $_GET["sondetemp"];
   $CO2 = $_GET["gas"];
   $O2 = $_GET["gas2"];


$servername = "localhost";
$username = "BPSN";
$password = "serreconnectee";
$dbname = "serreconnectee";

/*// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//$sql = "INSERT INTO test.sensor (value) VALUES ('".$_GET["value"]."')";    
$sql = "INSERT INTO sensor (temp, hum, hc) VALUES ($temperature, $humidity, $hc)"; 

    // Execute SQL statement

    if (mysqli_query($conn, $sql)) {
  		echo "New record created successfully";
	} 
	else {
  		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);*/



$conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }

   $conn->query($sql);

   $sql = "INSERT INTO sensor (temp, hum, hc, humsol, sondetemp, gas, gas2) VALUES ($temperature, $humidity, $hc, $humiditesol, $sondetemp, $CO2, $O2)";
//     $sql = "INSERT INTO sensor (temp, hum, hc, humsol) VALUES ($temperature, $humidity, $hc, $humiditesol)";

   if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
   } else {
      echo "Error: " . $sql . " => " . $conn->error;
   }

   $conn->close();
} else {
   echo "temperature is not set";
}
?>
