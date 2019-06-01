<!DOCTYPE html>
<html>
	<head>
		<title>archivio v1.0</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="../stili_css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nova+Square" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
		<script src="../javascript/script.js"></script>


	</head>
	<body class="sfondo">
		<?php
			require_once("funzioni_php.php");

			if(isset($_POST["_numero"]))
			{
				$numero=$_POST["_numero"];
				//echo("<p>numero: ".$numero."</p>");

				if(isset($_POST["_anno"]))
				{
					$anno=$_POST["_anno"];
					//echo("<p>anno: ".$anno."</p>");

					if(isset($_POST["_select_modello"]))
					{
						$modello=$_POST["_select_modello"];
						//echo("<p>modello: ".$modello."</p>");


						if(isset($_POST["_select_archivio"]))
						{
							$nome_archivio=$_POST["_select_archivio"];

							$query_chiave_archivio="SELECT id, nome FROM tabella_archivi WHERE nome='".$nome_archivio."';";

							$conn=connessione_db();
							$riga_archivio=mysqli_query($conn,$query_chiave_archivio) -> fetch_array();
							chiudi_connessione_db($conn);

							$archivio=$riga_archivio['id'];

							//echo("<p>archivio: ".$archivio."</p>");

						}
						else
							$archivio=NULL;

						if(isset($_POST["_scelta"]))
						{
							$scelta=$_POST["_scelta"];
							//echo("<p>scelta: ".$scelta."</p>");
							switch($scelta)
							{
								case "entrata":
									aggiungi_fascicolo($numero, $anno, $modello, $archivio, $nome_archivio);break;

								case "uscita":
									uscita_fascicolo($numero, $anno, $modello, $archivio, $nome_archivio);break;

								case "cerca":
									ricerca_fascicolo($numero, $anno, $modello, $archivio, $nome_archivio);break;
							}
						}
					}
				}
			}

			function aggiungi_fascicolo($numero, $anno, $modello, $archivio, $nome_archivio)
			{

				$query_ricerca="SELECT id, numero, anno, modello, e_in_archivio FROM tabella_fascicoli WHERE numero=".$numero." AND anno=".$anno." AND modello LIKE '".$modello."';";

				$conn=connessione_db();
				$riga_archivio=mysqli_query($conn,$query_ricerca) -> fetch_array();
				chiudi_connessione_db($conn);


				echo'<div class="pos-f-t" style="background:#10ff00b3;">';
				echo'		<div class="col-md-6 offset-md-3 col-sm-12">';
				echo'			<nav class="navbar navbar-dark navbar_personalizzata">';
				echo'			<p class="grassetto" style="color:black; width:100%; text-align:right;">Fascicolo in entrata</p>';
				echo'		</nav>';
				echo'	</div>';
				echo'</div>';


				echo'<div class="container-fluid corpo_centrale">';



				$data_corrente = date("Y-m-d");
				$passato=false;

				if($riga_archivio==NULL)
				{
					$query_inserimento="

						INSERT INTO  `tabella_fascicoli`
						(`numero`, `anno`, `modello`, `legame_archivio`, `e_in_archivio`, `data_di_archiviazione`, `data_uscita_archivio`)
						VALUES ('".$numero."', '".$anno."', '".$modello."', '".$archivio."', 1, '".$data_corrente."', NULL);";

					//echo $data_corrente;

					$conn=connessione_db();
					mysqli_query($conn,$query_inserimento);
					chiudi_connessione_db($conn);
					//echo "FASCICOLO AGGIUNTO!";
					$passato=true;

				}
				else
				{
					if(!$riga_archivio['e_in_archivio'])
					{
						$query_inserimento="UPDATE tabella_fascicoli SET e_in_archivio = 1, data_uscita_archivio=NULL, data_di_archiviazione='".$data_corrente."', legame_archivio=".$archivio." WHERE id=".$riga_archivio['id'].";";
						$conn=connessione_db();
						mysqli_query($conn,$query_inserimento);
						chiudi_connessione_db($conn);
						$passato=true;
					}
				}

				if($passato)
				{

					echo'	<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'		<h2 class="title titolo titolo_selezionato">Operazione riuscita!</h2>';
					echo'	</div>';


					echo'	<div class="row">';
					echo' 		<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">';
					echo'			<div class="row">';
					
					echo'				<div class="card-header	col-md-6 offset-md-3 col-sm-12 form_opzione" id="background_form_aggiungi">';

					echo'					<div class="form-group col-md-8 offset-md-2">';
					echo'						<label class="label_standard col-12" style="text-align:center; color:#0058ff;"><strong>Fascicolo aggiunto:</strong></label>';
					echo'						<label class="label_standard col-12" style="text-align:center;">Numero: '.$numero.'</label>';
					echo'						<label class="label_standard col-12" style="text-align:center;">Anno: '.$anno.'</label>';
					echo'						<label class="label_standard col-12" style="text-align:center;">Modello: '.$modello.'</label>';
					echo'						<label class="label_standard col-12" style="text-align:center;">Archivio: '.$nome_archivio.'</label>';
					$percorso="'../index.php'";
					echo'						<button class="btn btn-primary bottone_indietro_forms col-10 col-xl-6 offset-1 offset-xl-3" onclick="window.location.href='.$percorso.'" >Menu principale</button>';
					echo'					</div>';
					echo'				</div>';
					echo'			</div>';
					echo'		</div>';
					echo'	</div>';

				}
				else
				{
					echo'	<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'		<h2 class="title titolo titolo_selezionato" style="color:red;">Operazione annullata!</h2>';
					echo'	</div>';


					echo'	<div class="row">';
					echo' 		<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">';
					echo'			<div class="row">';
					echo'				<div class="card-header	col-md-6 offset-md-3 col-sm-12 form_opzione" id="background_form_aggiungi">';

					echo'					<div class="form-group col-md-8 offset-md-2">';
					echo'						<label class="label_standard col-12" style="text-align:center;"><strong>Fascicolo gi&agrave; presente in archivio</strong></label>';
					$percorso="'../index.php'";
					echo'						<button class="btn btn-primary bottone_indietro_forms col-10 col-xl-6 offset-1 offset-xl-3" onclick="window.location.href='.$percorso.'" >Menu principale</button>';
					echo'					</div>';
					echo'				</div>';
					echo'			</div>';
					echo'		</div>';
					echo'	</div>';
				}


				echo'</div>';

			}

			function uscita_fascicolo($numero, $anno, $modello, $archivio, $nome_archivio)
			{

				$query_ricerca="SELECT id, numero, anno, modello, e_in_archivio, legame_archivio FROM tabella_fascicoli WHERE numero=".$numero." AND anno=".$anno." AND modello LIKE '".$modello."' AND e_in_archivio=1;";

				$conn=connessione_db();
				$riga_archivio=mysqli_query($conn,$query_ricerca) -> fetch_array();
				chiudi_connessione_db($conn);
				$id_fascicolo_in_uscita=$riga_archivio['id'];
				
				
				$query_nome_archivio="SELECT id, nome FROM tabella_archivi WHERE id='".$riga_archivio['legame_archivio']."';";

				$conn=connessione_db();
				$riga_archivio=mysqli_query($conn,$query_nome_archivio) -> fetch_array();
				chiudi_connessione_db($conn);

				$nome_archivio=$riga_archivio['nome'];
				

				$data_corrente = date("Y-m-d");


				echo'<div class="pos-f-t" style="background:#ff2e2eb3;">';
				echo'	<div class="col-md-6 offset-md-3 col-sm-12">';
				echo'		<nav class="navbar navbar-dark navbar_personalizzata">';
				echo'			<p class="grassetto" style="color:black; width:100%; text-align:right;">Fascicolo in uscita</p>';
				echo'		</nav>';
				echo'	</div>';
				echo'</div>';


				echo'<div class="container-fluid corpo_centrale">';

				if($riga_archivio!=null)
				{
					//$query_eliminazione="DELETE FROM tabella_fascicoli WHERE tabella_fascicoli.id =".$id_fascicolo_da_cancellare.";";
					$query_uscita_fascicolo="UPDATE `tabella_fascicoli` SET  `e_in_archivio` =  '0', `data_di_archiviazione` =  NULL, `data_uscita_archivio` =  '".$data_corrente."' WHERE  `tabella_fascicoli`.`id` =".$id_fascicolo_in_uscita.";";




					$conn=connessione_db();
					mysqli_query($conn,$query_uscita_fascicolo);
					chiudi_connessione_db($conn);
					//echo "FASCICOLO USCITO";

					//echo'</div>';


					echo'<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'	<h2 class="title titolo titolo_selezionato">Operazione riuscita!</h2>';
					echo'</div>';


					echo'<div class="row">';
					echo' 	<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">';
					echo'		<div class="row">';
					echo'			<div class="card-header	col-md-6 offset-md-3 col-sm-12 form_opzione" id="background_form_elimina">';

					echo'				<div class="form-group col-md-8 offset-md-2">';
					echo'					<label class="label_standard col-12" style="text-align:center; color:#0058ff;"><strong>Fascicolo uscito:</strong></label>';
					echo'					<label class="label_standard col-12" style="text-align:center;">Numero: '.$numero.'</label>';
					echo'					<label class="label_standard col-12" style="text-align:center;">Anno: '.$anno.'</label>';
					echo'					<label class="label_standard col-12" style="text-align:center;">Modello: '.$modello.'</label>';
					echo'					<label class="label_standard col-12" style="text-align:center;">Archivio: '.$nome_archivio.'</label>';
					$percorso="'../index.php'";
					echo'					<button class="btn btn-primary bottone_indietro_forms col-10 col-xl-6 offset-1 offset-xl-3" onclick="window.location.href='.$percorso.'" >Menu principale</button>';
					echo'				</div>';
					echo'			</div>';
					echo'		</div>';
					echo'	</div>';


				}
				else
				{
					//echo "FASCICOLO NON ESISTENTE";
					echo'	<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'		<h2 class="title titolo titolo_selezionato" style="color:red;">Operazione annullata!</h2>';
					echo'	</div>';


					echo'	<div class="row">';
					echo' 		<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">';
					echo'			<div class="row">';
					echo'				<div class="card-header	col-md-6 offset-md-3 col-sm-12 form_opzione" id="background_form_elimina">';

					echo'					<div class="form-group col-md-8 offset-md-2">';
					echo'						<label class="label_standard col-12" style="text-align:center;"><strong>Fascicolo non presente in archivio</strong></label>';
					$percorso="'../index.php'";
					echo'						<button class="btn btn-primary bottone_indietro_forms col-10 col-xl-6 offset-1 offset-xl-3" onclick="window.location.href='.$percorso.'" >Menu principale</button>';
					echo'					</div>';
					echo'				</div>';
					echo'			</div>';
					echo'		</div>';
					echo'	</div>';
				}

				echo'</div>';

			}

			function ricerca_fascicolo($numero, $anno, $modello, $archivio, $nome_archivio)
			{

				if($archivio != NULL)
					$query_ricerca="SELECT id, numero, anno, modello, legame_archivio, e_in_archivio, data_di_archiviazione, data_uscita_archivio FROM tabella_fascicoli WHERE numero=".$numero." AND anno=".$anno." AND modello LIKE '".$modello."' AND legame_archivio=".$archivio.";";
				else
					$query_ricerca="SELECT id, numero, anno, modello, legame_archivio, e_in_archivio, data_di_archiviazione, data_uscita_archivio FROM tabella_fascicoli WHERE numero=".$numero." AND anno=".$anno." AND modello LIKE '".$modello."';";

				$conn=connessione_db();
				$riga_archivio=mysqli_query($conn,$query_ricerca) -> fetch_array();
				chiudi_connessione_db($conn);

				//print_r($riga_archivio);

				if($archivio==NULL && $riga_archivio!=NULL)
				{
					$query_chiave_archivio="SELECT id, nome FROM tabella_archivi WHERE id=".$riga_archivio['legame_archivio'].";";

					$conn=connessione_db();
					$riga_archivio_del_fascicolo=mysqli_query($conn,$query_chiave_archivio) -> fetch_array();
					chiudi_connessione_db($conn);

					$nome_archivio=$riga_archivio_del_fascicolo['nome'];
				}


				echo'<div class="pos-f-t" style="background:#efff00b3;">';
				echo'		<div class="col-md-6 offset-md-3 col-sm-12">';
				echo'			<nav class="navbar navbar-dark navbar_personalizzata">';
				echo'			<p class="grassetto" style="color:black; width:100%; text-align:right;">Fascicolo in uscita</p>';
				echo'		</nav>';
				echo'	</div>';
				echo'</div>';

				echo'<div class="container-fluid corpo_centrale">';

				if($riga_archivio!=NULL)
				{
					echo'<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'	<h2 class="title titolo titolo_selezionato">Operazione riuscita!</h2>';
					echo'</div>';


					echo'<div class="row">';
					echo' 	<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">';
					echo'		<div class="row">';


					echo'			<div class="card-header	col-md-8 col-xl-6 offset-md-2 offset-xl-3 col-sm-12 form_opzione" id="background_form_ricerca">';

					echo'				<div class="form-group col-md-10 col-xl-8 offset-md-1 offset-xl-2">';
					echo'					<label class="label_standard col-12" style="text-align:center; color:#0058ff;"><strong>Fascicolo trovato:</strong></label>';

					if($riga_archivio['e_in_archivio'])
						echo'				<div class="card-header col-12 fascicolo_cercato_presente">';
					else
						echo'				<div class="card-header col-12 fascicolo_cercato_assente">';

					echo'						<label class="label_standard col-12" style="text-align:center;">Numero: '.$numero.'</label>';
					echo'						<label class="label_standard col-12" style="text-align:center;">Anno: '.$anno.'</label>';
					echo'						<label class="label_standard col-12" style="text-align:center;">Modello: '.$modello.'</label>';

					if($riga_archivio['e_in_archivio'])
					{
						echo'					<label class="label_standard col-12" style="text-align:center;">Archiviato in data: '.$riga_archivio['data_di_archiviazione'].'</label>';
						echo'					<label class="label_standard col-12" style="text-align:center;">Archivio: '.$nome_archivio.'</label>';
					}
					else
					{
						echo'					<label class="label_standard col-12" style="text-align:center;">Non archiviato!';
						echo'					<label class="label_standard col-12" style="text-align:center;">Data di uscita: '.$riga_archivio['data_uscita_archivio'].'</label>';
					}
					echo'					</div>';
					

					//echo'<div class="card-header col-12 fascicolo_cercato"> <label class="label_standard col-12" style="text-align:center;">Numero: '.$numero.', Anno: '.$anno.', Modello: '.$modello.', Archivio: '.$nome_archivio.' </label> </div>';


					$percorso="'../index.php'";
					echo'			<button class="btn btn-primary bottone_indietro_forms col-10 col-xl-6 offset-1 offset-xl-3" onclick="window.location.href='.$percorso.'" >Menu principale</button>';
					echo'				</div>';
					echo'			</div>';
					echo'		</div>';
					echo'	</div>';
					echo'</div>';
				}
				else
				{
					echo'	<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'		<h2 class="title titolo titolo_selezionato" style="color:red;">Operazione annullata!</h2>';
					echo'	</div>';


					echo'	<div class="row">';
					echo' 		<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">';
					echo'			<div class="row">';
					echo'				<div class="card-header	col-md-6 offset-md-3 col-sm-12 form_opzione" id="background_form_ricerca">';

					echo'					<div class="form-group col-md-8 offset-md-2">';
					echo'						<label class="label_standard col-12" style="text-align:center;"><strong>Fascicolo non presente in archivio</strong></label>';
					$percorso="'../index.php'";
					echo'						<button class="btn btn-primary bottone_indietro_forms col-10 col-xl-6 offset-1 offset-xl-3" onclick="window.location.href='.$percorso.'" >Menu principale</button>';
					echo'					</div>';
					echo'				</div>';
					echo'			</div>';
					echo'		</div>';
					echo'	</div>';
				}



				echo'</div>';
			}


		?>
	</body>
</html>
