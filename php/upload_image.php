<!DOCTYPE html>
<html>
	<!-- 
	Name: Simple PHP Upload
	Version: 1.0
	Copyright: Isacco Coccato - www.giacobbe85.altervista.org

	Please read readme_eng.txt for more informations
	Per favore, leggi readme_ita.txt per maggiori informazioni

	 -->
	 <script>
		window.location.href = '../selezioni/impostazioni/impostazioni.php'
	 </script>

	<?PHP
	session_start();
	require_once('funzioni_php.php');
	# ----- Settings ----

	# Set here the upload directory. The path is relative
	# Imposta quì il percorso di upload.  Il percorso è relativo
	$target_path = "../immagini/foto_profilo/";

	# Messaggio in caso di upload eseguito correttamente (di default in italiano)
	# Correct upload message (default Italian language)
	$ok = "Il file &egrave; stato caricato<BR><BR>";

	# Messaggio di errore (di default in italiano)
	# Error message  (default Italian language)
	$errore = "C'&egrave; stato un errore.";

	# Messaggio di nuovo upload (di default in italiano)
	# Another upload message (default Italian language)
	$ancora = "Carica ancora";

	# Program
	$filename=$_FILES["uploadedfile"]["name"];
	$extension=end(explode(".", $filename));
	$newfilename= $_SESSION["username"]."_foto_profilo".".".$extension;
	
	$target_path = $target_path . basename($newfilename); 
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
	{
		//$dimensione=($_FILES['uploadedfile']['size'])/1000000;
		//echo $ok . basename( $_FILES['uploadedfile']['name']) . "<BR>" . $dimensione . " Mb";
		$nome_foto_profilo_query="SELECT nome_foto FROM foto_profili where username='".$_SESSION["username"]."';";
		$conn = connessione_db();
		$nome_foto_profilo=mysqli_query($conn,$nome_foto_profilo_query) -> fetch_array();
		
		
		
		if($nome_foto_profilo["nome_foto"] == 'default_user.png')
		{
			$nome_foto_profilo_query="UPDATE foto_profili SET `nome_foto` = '".$_SESSION["username"]."_foto_profilo.".$extension."' WHERE `foto_profili`.`username` = '".$_SESSION["username"]."';";
			$conn=connessione_db();
			mysqli_query($conn,$nome_foto_profilo_query);
			chiudi_connessione_db($conn);
		}
		else
		{
			if($nome_foto_profilo["nome_foto"] != $_SESSION["username"]."_foto_profilo.".$extension )
			{
				unlink("../immagini/foto_profilo/".$nome_foto_profilo["nome_foto"]);
				$nome_foto_profilo_query="UPDATE foto_profili SET `nome_foto` = '".$_SESSION["username"]."_foto_profilo.".$extension."' WHERE `foto_profili`.`username` = '".$_SESSION["username"]."';";
				$conn=connessione_db();
				mysqli_query($conn,$nome_foto_profilo_query);
				chiudi_connessione_db($conn);
			}
		}
		
	} 
	else{
	   // echo $errore;
	}
	?>
</html>
