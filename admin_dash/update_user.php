<?php 
include('../connex.php');
$pseudo = $_POST['pseudo'];
$email = $_POST['email'];
$droit = $_POST['droit'];
$active = $_POST['active'];
$date_inscription = $_POST['date_inscription'];
$last_activity = $_POST['last_activity'];
$id = $_POST['id'];

$sql = "UPDATE `utilisateurs` SET  `pseudo`='$pseudo' , `email`= '$email', `droit`='$droit', `active`='$active',  `date_inscription`='$date_inscription',  `last_activity`='$last_activity' WHERE id='$id' ";
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