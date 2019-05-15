<?php
	function connessione_db()
	{

		$servername = "localhost";
		$username = "how2macca";
		$password = "";
		$nome_db="my_how2macca";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $nome_db);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}

	function chiudi_connessione_db($conn)
	{
		mysqli_close($conn);
	}

	function opzioni_select_archivi($conn)
	{
		$nome_archivi=mysqli_query($conn,"SELECT nome FROM tabella_archivi");
		while($row = $nome_archivi->fetch_array())
		{
			echo "<option>".$row['nome']."</option>";
		}
	}

	function impostazoni_div_archivi($conn)
	{
		$nome_archivi=mysqli_query($conn,"SELECT nome FROM tabella_archivi ORDER BY id");
		$i=1;

		echo '<div class="row">';
		while($row = $nome_archivi->fetch_array())
		{
			if($i==1)
				echo'<div class="card-header col-md-3 archivio" onclick="seleziona_piu(this, \'archivio_selezionato\', \'archivio\');">';
			else
				echo'<div class="card-header offset-md-1 col-md-3 archivio"  onclick="seleziona_piu(this, \'archivio_selezionato\', \'archivio\');">';

			echo"	<p class=\"testo_archivio\">".$row['nome']."</p>";
			echo'</div>';
			if($i==3)
			{
				echo '</div>';
				echo '<div class="row">';
				$i=0;
			}
			$i++;
		}
		echo '</div>';
	}


	//Login

	function generateRandomString()
	{
		$length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}

	function crea_token($username)
	{
		session_start();
		do{
			$rifai=false;
			$token=generateRandomString();

			$cerca_token="SELECT token FROM `connessi` WHERE `token` LIKE '".$token."';";
			$conn=connessione_db();
			$riga_utente=mysqli_query($conn,$cerca_token) -> fetch_array();
			chiudi_connessione_db($conn);
			if($riga_utente != null)
				$rifai=true;
		}while($rifai);

		$inserisci_token="INSERT INTO `connessi` (`id`, `username`, `token`) VALUES (NULL, '".$username."', '".$token."');";
		$conn=connessione_db();
		$inserimento=mysqli_query($conn,$inserisci_token);
		chiudi_connessione_db($conn);
		$_SESSION['token']=$token;

		if($inserimento)
			return true;
		else
			return false;

	}

	function controlla_login_token($percorso)
	{
		session_start();

		$cerca_username_token="SELECT username, token FROM `connessi` WHERE `username` LIKE '".$_SESSION['username']."' AND `token` LIKE '".$_SESSION['token']."';";
		$conn = connessione_db();
		$connesso=mysqli_query($conn,$cerca_username_token);
		chiudi_connessione_db($conn);

		if($connesso->fetch_array() == null)
		{
			//die("Token errato, rieffettuare il login");
			echo"<script> window.location.href='".$percorso."' </script>";
		}
	}


?>
