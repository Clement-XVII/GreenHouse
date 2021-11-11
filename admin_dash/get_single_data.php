<?php include('../connex.php');
$id = $_POST['id'];
$sql = "SELECT * FROM utilisateurs WHERE id='$id' LIMIT 1";
$query = mysqli_query($connexion,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
?>
