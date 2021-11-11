<?php 
include('../connex.php');
$pseudo = $_POST['pseudo'];
$email = $_POST['email'];
$droit = $_POST['droit'];
$active = $_POST['active'];
$date_inscription = $_POST['date_inscription'];

$sql = "INSERT INTO `utilisateurs` (`pseudo`,`email`,`droit`, `active`,`date_inscription`) values ('$pseudo', '$email', '$droit', '$active', '$date_inscription' )";
$query= mysqli_query($connexion,$sql);
$lastId = mysqli_insert_id($connexion);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
      
    );

    echo json_encode($data);
} 

?>