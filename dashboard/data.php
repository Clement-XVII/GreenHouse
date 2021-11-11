<?php
header('Content-Type: application/json');
//$conn = mysqli_connect("localhost","BPSN","serreconnectee","serreconnectee");
include "../connex.php";

$sqlQuery = "SELECT id,time,temp FROM sensor WHERE sensor.time BETWEEN CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 1 DAY ORDER BY id ASC"; //CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 1 DAY

$result = mysqli_query($connexion,$sqlQuery);

$data = array();
foreach ($result as $row) {
$data[] = $row;
}

mysqli_close($connexion);

echo json_encode($data);
?>
