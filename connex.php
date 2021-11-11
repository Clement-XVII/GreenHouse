<?php
$host ='localhost';
$user ='BPSN';
$pass ='serreconnectee';
$database='serreconnectee';

$connexion = mysqli_connect($host,$user,$pass,$database);

if (!$connexion)
{
	echo "la connexion à MYSQL a échoué....";
}
?>
