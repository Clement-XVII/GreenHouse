<?php
// Database Connection
require("../../connex.php");

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
header('Content-Disposition: attachment; filename=sensor.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Time', 'Temperature °C', 'Humidite %', 'Indice de temperature °C', 'Humidite du sol %', 'Sonde Temperature °C', 'CO2 %', 'O2 %'));

if (count($sensor) > 0) {
    foreach ($sensor as $row) {
        fputcsv($output, $row);
    }
}
?>
