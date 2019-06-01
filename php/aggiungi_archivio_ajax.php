<?php
	require_once("../php/funzioni_php.php");
	//print_r($_POST);
	header("Content-Type: application/json; charset=UTF-8");
  if(isset($_POST["_nome_archivio"]))
  {
      $query_cerca_archivio="SELECT nome FROM  `tabella_archivi` WHERE  `nome` LIKE  '".$_POST["_nome_archivio"]."';";
      $conn=connessione_db();
      $ricerca_archivio=mysqli_query($conn,$query_cerca_archivio) -> fetch_array();;
      chiudi_connessione_db($conn);

      if($ricerca_archivio == null)
      {
          $query_aggiungi_archivio="INSERT INTO `tabella_archivi` (`id` ,`nome`)VALUES (NULL ,  '".$_POST["_nome_archivio"]."');";
          $conn=connessione_db();
          $riga_archivio=mysqli_query($conn,$query_aggiungi_archivio);
          chiudi_connessione_db($conn);
					$dati="";
      }
      else
				$dati="$_POST['_nome_archivio']";
			echo json_encode($dati);
  }
?>
