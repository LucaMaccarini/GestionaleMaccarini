<?php
	require_once("../php/funzioni_php.php");
	//print_r($_POST);
    if(isset($_POST["_nome_archivio"]) &&  isset($_POST["_pagina"]))
    {
		$archivio=$_POST["_nome_archivio"];
		$fascicoli_passati=30;
		if($archivio=="- seleziona archivio -")
			$query_ricerca_presenti="SELECT numero, anno, modello, nome as archivio, e_in_archivio, data_di_archiviazione as data FROM `tabella_fascicoli` INNER JOIN tabella_archivi on legame_archivio=tabella_archivi.id WHERE e_in_archivio=1 ORDER BY anno DESC, numero  LIMIT ".$fascicoli_passati * ($_POST["_pagina"]-1).",1;";
		else
			$query_ricerca_presenti="SELECT numero, anno, modello, nome as archivio, e_in_archivio, data_di_archiviazione as data FROM `tabella_fascicoli` INNER JOIN tabella_archivi on legame_archivio=tabella_archivi.id WHERE e_in_archivio=1 and nome='".$archivio."' ORDER BY anno DESC, numero LIMIT ".$fascicoli_passati * ($_POST["_pagina"]-1).",1;";
		
		
		$conn=connessione_db();
		$ricerca_archivio_presenti=mysqli_query($conn,$query_ricerca_presenti);
		chiudi_connessione_db($conn);
		
		if($ricerca_archivio_presenti != null)
		{
			//print_r( $nome_archivi);
			header("Content-Type: application/json; charset=UTF-8");	
			$dati=mysqli_fetch_all($ricerca_archivio_presenti,MYSQLI_ASSOC);
			echo json_encode($dati);
		}	

    }
?>