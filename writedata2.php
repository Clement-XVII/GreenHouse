<?php
include "connex.php";
if(isset($_GET["temp"])) {
   $temperature = $_GET["temp"]; // get temperature value from HTTP GET
   $humidity = $_GET["hum"];
   $hc = $_GET["hc"];
   $humiditesol = $_GET["humsol"];
   $sondetemp = $_GET["sondetemp"];
   $CO2 = $_GET["gas"];
   $O2 = $_GET["gas2"];
   $ldr = $_GET["ldr"];


$connexion = new mysqli($host, $user, $pass, $database);
   // Check connection
   if ($connexion->connect_error) {
      die("Connection failed: " . $connexion->connect_error);
   }

   $connexion->query($sql);

   $sql = "INSERT INTO sensor (temp, hum, hc, humsol, sondetemp, gas, gas2, ldr) VALUES ($temperature, $humidity, $hc, $humiditesol, $sondetemp, $CO2, $O2, $ldr)";
//     $sql = "INSERT INTO sensor (temp, hum, hc, humsol) VALUES ($temperature, $humidity, $hc, $humiditesol)";

   if ($connexion->query($sql) === TRUE) {
      echo "New record created successfully";
   } else {
      echo "Error: " . $sql . " => " . $connexion->error;
   }

   $connexion->close();
} else {
   echo "data is not set";
}
?>
