<?php
	require_once("../funzioni_php.php");
	session_start();
	
	$ip=$_SERVER["REMOTE_ADDR"]; 
	
	$cancella_token="DELETE FROM `my_how2macca`.`connessi` WHERE `connessi`.`ip` = '".$ip."';";

	$conn=connessione_db();
	mysqli_query($conn,$cancella_token);
	chiudi_connessione_db($conn);

	echo"<script> window.location.href='../../login/login.php' </script>";


?>
