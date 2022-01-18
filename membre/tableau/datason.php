<?php
include "../connex.php";
$query = "SELECT * FROM sensor ORDER BY id ASC";
$result = $connexion->query($query);

header('Content-Type: application/json');
$data = array();
while ( $row = $result->fetch_assoc() ) {
  $data[] = $row;
}
echo json_encode($data);
mysqli_close($connexion);
?>
