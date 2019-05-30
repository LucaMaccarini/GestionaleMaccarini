<?php
	require_once("../funzioni_php.php");
	session_start();

	if(isset($_POST["username"]))
	{
		if(isset($_POST["pass"]))
		{
			if(isset($_POST["pass2"]))
			{
				if(file_exists ('../../login/registrazione_sbloccata.html') )
				{
					$cerca_utente="SELECT username FROM `utenti` WHERE `username` = '".$_POST["username"]."';";
					$conn=connessione_db();
					$riga_utente=mysqli_query($conn,$cerca_utente) -> fetch_array();
					chiudi_connessione_db($conn);
					if($riga_utente == NULL)
					{
						//registrazione
						$password_criptata=crypt($_POST["pass"]);
						$registra_utente="INSERT INTO `utenti` (`id`, `username`, `password`) VALUES (NULL, '".$_POST["username"]."','".$password_criptata."');";
						$conn=connessione_db();
						mysqli_query($conn,$registra_utente);
						chiudi_connessione_db($conn);
						$_SESSION['username']=$_POST["username"];
						
						$inserisci_nome_foto_profilo_query="INSERT INTO foto_profili (`id`, `username`, `nome_foto`) VALUES (NULL, '".$_POST["username"]."', 'default_user.png');";
						$conn=connessione_db();
						mysqli_query($conn,$inserisci_nome_foto_profilo_query);
						chiudi_connessione_db($conn);
						
						if(crea_token())
						{
							//echo "ok";
							echo"<script> window.location.href='../../index.php' </script>";
						}
						else
							echo"errore durante la creazione del token";

					}
					else
						echo "Utente già registrato";
				}
				else
					echo 'la registrazione è stata bloccata!';

			}
			else
			{
				//login

				$logga_utente="SELECT password FROM `utenti` WHERE `username` = '".$_POST["username"]."';";
				$conn=connessione_db();
				$riga_utente=mysqli_query($conn,$logga_utente) -> fetch_array();
				chiudi_connessione_db($conn);
				if($riga_utente != NULL)
				{
					if(password_verify($_POST["pass"], $riga_utente["password"]))
					{
						$_SESSION['username']=$_POST["username"];
						//echo"loggato";
						if(crea_token())
						{
							//echo "ok";
							echo"<script> window.location.href='../../index.php' </script>";
						}
						else
							echo"errore durante la creazione del token";

					}
					else
						echo"<script> window.location.href='../../login/login_registrazione_errata.php?errore=2' </script>";
				}
				else
					echo"<script> window.location.href='../../login/login_registrazione_errata.php?errore=1' </script>";
			}
		}
	}

?>
