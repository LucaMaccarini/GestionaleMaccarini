<?php
	require_once("../php/funzioni_php.php");
	//print_r($_POST);
    if(isset($_POST["_nomi_archivi_da_eliminare"]))
    {
		$archivio_da_rimuovere=explode(",",$_POST["_nomi_archivi_da_eliminare"]);
		$stringa_non_eliminati="archivi non eliminati perchè contengono dei fascicoli archiviati:\n";
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
					
					if($eliminato)
					{
						$eliminati+=$archivio+", ";
					}	
					
				}
				else
				{
						$stringa_non_eliminati=$stringa_non_eliminati.$archivio.", ";
						$non_eliminati_flag=true;
						
						
				}
				
			}

		}
		if($non_eliminati_flag)
		{
			echo substr($stringa_non_eliminati,0,strlen($stringa_non_eliminati)-2);
		}
		//print_r($archivio_da_rimuovere);
    }
?>