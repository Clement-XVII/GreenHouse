<?php
// Database Connection
require("../connex.php");

// get Users
$query = "SELECT * FROM sensor";
if (!$result = mysqli_query($connexion, $query)) {
    exit(mysqli_error($connexion));
}

$sensor = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sensor[] = $row;
    }
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=sensors.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Time', 'Temperature °C', 'Humidite %', 'Indice de Temperature', 'Humidite du Sol %', 'Sonde de Temperature °C', 'C02 (ppm)', 'O2 (%)', 'LDR (LUX)'));

if (count($sensor) > 0) {
    foreach ($sensor as $row) {
        fputcsv($output, $row);
    }
}
?>