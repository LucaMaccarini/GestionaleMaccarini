<?php
	session_start();
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
		$length = 30;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}

	function crea_token()
	{
		$ip=$_SERVER["REMOTE_ADDR"]; 
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

		$cerca_usename="SELECT id FROM `connessi` WHERE `ip` = '".$ip."';";
		$conn=connessione_db();
		$ricerca=mysqli_query($conn,$cerca_usename);
		chiudi_connessione_db($conn);
		
		$id_ricerca=$ricerca->fetch_array();
		//echo $id_ricerca['id'];
		if($id_ricerca != null)
		{
			$inserisci_token="UPDATE `connessi` SET `token` = '".$token."' WHERE `connessi`.`id` = ".$id_ricerca['id'].";";
			$conn=connessione_db();
			$inserimento=mysqli_query($conn,$inserisci_token);
			chiudi_connessione_db($conn);
			$_SESSION['token']=$token;
		}
		else
		{
			$inserisci_token="INSERT INTO `connessi` (`id`, `ip`, `token`) VALUES (NULL, '".$ip."', '".$token."');";
			$conn=connessione_db();
			$inserimento=mysqli_query($conn,$inserisci_token);
			chiudi_connessione_db($conn);
			$_SESSION['token']=$token;
		}

		if($inserimento)
			return true;
		else
			return false;

	}

	function controlla_login_token($percorso)
	{
		$ip=$_SERVER["REMOTE_ADDR"]; 
		$cerca_username_token="SELECT ip, token FROM `connessi` WHERE `ip` LIKE '".$ip."' AND `token` LIKE '".$_SESSION['token']."';";
		$conn = connessione_db();
		$connesso=mysqli_query($conn,$cerca_username_token);
		chiudi_connessione_db($conn);

		if($connesso->fetch_array() == null)
		{
			//die("Token errato, rieffettuare il login");
			echo"<script> window.location.href='".$percorso."' </script>";
		}
	}
	
	function get_numero_archiviati()
	{
		

		$conta_archiviati="SELECT count(id) as archiviati FROM tabella_fascicoli where e_in_archivio=1";
		$conn = connessione_db();
		$connesso=mysqli_query($conn,$conta_archiviati);
		chiudi_connessione_db($conn);
		
		$numero_archiviati=$connesso->fetch_array();
		if( $numero_archiviati!= null)
		{
			echo $numero_archiviati['archiviati'];
		}
	}
	
	function get_numero_disarchiviati()
	{
		

		$conta_archiviati="SELECT count(id) as archiviati FROM tabella_fascicoli where e_in_archivio=0";
		$conn = connessione_db();
		$connesso=mysqli_query($conn,$conta_archiviati);
		chiudi_connessione_db($conn);
		
		$numero_archiviati=$connesso->fetch_array();
		if( $numero_archiviati!= null)
		{
			echo $numero_archiviati['archiviati'];
		}
	}
	
	
	function get_nome_foto_profilo($username)
	{
		

		$conta_archiviati="SELECT nome_foto FROM foto_profili where username='".$username."';";
		$conn = connessione_db();
		$nome_foto=mysqli_query($conn,$conta_archiviati) -> fetch_array();
		chiudi_connessione_db($conn);
		return $nome_foto["nome_foto"];
	}


?>
