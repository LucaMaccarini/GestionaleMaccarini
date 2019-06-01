<?php
	require_once("../php/funzioni_php.php");
	//print_r($_POST);
    if(isset($_POST["_nomi_archivi_da_eliminare"]))
    {
		$archivio_da_rimuovere=explode(",",$_POST["_nomi_archivi_da_eliminare"]);
		$archivi_non_eliminati = array();
		$non_eliminati_flag=false;
		foreach ($archivio_da_rimuovere as $archivio)
		{
			$query_id_archivio="SELECT id FROM tabella_archivi WHERE `tabella_archivi`.`nome` ='".$archivio."';";
			$conn=connessione_db();
			$riga_id_archivio=mysqli_query($conn,$query_id_archivio) -> fetch_array();
			chiudi_connessione_db($conn);

			if($riga_id_archivio != null)
			{
				$fascicoli_nel_archivio="SELECT id FROM `tabella_fascicoli` WHERE `legame_archivio` = ".$riga_id_archivio['id']." AND `e_in_archivio` = 1";
				$conn=connessione_db();
				$riga_fascicoli_in_archivio=mysqli_query($conn,$fascicoli_nel_archivio) -> fetch_array();
				chiudi_connessione_db($conn);

				if($riga_fascicoli_in_archivio==null)
				{

					$query_elimina_archivio="DELETE FROM tabella_archivi WHERE id=".$riga_id_archivio['id'].";";
					$conn=connessione_db();
					$eliminato=mysqli_query($conn,$query_elimina_archivio);
					chiudi_connessione_db($conn);
				}
				else
				{
						array_push($archivi_non_eliminati,$archivio);
						$non_eliminati_flag=true;
				}

			}

		}
		if($non_eliminati_flag)
		{
			header("Content-Type: application/json; charset=UTF-8");
			echo json_encode($archivi_non_eliminati);
		}
		else {
			echo"";
		}
		//print_r($archivio_da_rimuovere);
    }
?>
