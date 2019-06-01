<?
		require_once("../php/funzioni_php.php");
        $conn = connessione_db();
		$nome_archivi=mysqli_query($conn,"SELECT nome FROM tabella_archivi ORDER BY id");
        chiudi_connessione_db($conn);
		//print_r( $nome_archivi);
		header("Content-Type: application/json; charset=UTF-8");	
		$dati=mysqli_fetch_all($nome_archivi,MYSQLI_ASSOC);
		echo json_encode($dati);
?>