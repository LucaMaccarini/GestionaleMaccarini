<?php
	require_once("../php/funzioni_php.php");
	session_start();

	if(isset($_POST["_vecchia_password"]))
	{
		if(isset($_POST["_nuova_password"]))
		{
			if(isset($_POST["_ripeti_password"]))
			{
				if($_POST["_nuova_password"]==$_POST["_ripeti_password"])
				{
					//login

					$logga_utente="SELECT id, password FROM `utenti` WHERE `username` = '".$_SESSION['username']."';";
					$conn=connessione_db();
					$riga_utente=mysqli_query($conn,$logga_utente) -> fetch_array();
					chiudi_connessione_db($conn);
					if($riga_utente != NULL)
					{
						if(password_verify($_POST["_vecchia_password"], $riga_utente["password"]))
						{
							$password_criptata=crypt($_POST["_nuova_password"]);
							$logga_utente="UPDATE utenti SET `password` = '".$password_criptata."' WHERE `utenti`.`id` = ".$riga_utente["id"].";";
							$conn=connessione_db();
							$riga_utente=mysqli_query($conn,$logga_utente);
							
							echo'0'; //pass cambiata
							
						}
						else
							echo'1'; //passwoed errata
					}
			
				}
			}
		}
	}

?>
