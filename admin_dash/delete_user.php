<?php 
include('../connex.php');

$user_id = $_POST['id'];
$sql = "DELETE FROM utilisateurs WHERE id='$user_id'";
$delQuery =mysqli_query($connexion,$sql);
if($delQuery==true)
{
	 $data = array(
        'status'=>'success',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'failed',
      
    );

    echo json_encode($data);
} 

?>