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
			session_start();
			if(isset($_POST["_carica_archivio"]))
			{
				$archivio=$_POST["_carica_archivio"];
				//echo $archivio;
				echo'<div class="pos-f-t" style="background:#efff00b3;">';
				echo'	<div class="col-md-10 offset-md-1 col-sm-12">';
				echo'		<div class="collapse" id="navbarToggleExternalContent" style="text-align:center;">';
				echo'			<div class="p-4 spazio_utente">';
				echo'				<div class="row">';
				echo'					<img src="../immagini/default_user.png" class="foto_utente" >';
				echo'				</div>';
				echo'				<div class="row">';
				echo'					<h4 style="color:black; width:100%; text-align:center;">'.$_SESSION["username"].'</h4>';
				echo'				</div>';
				echo'			</div>';
				echo'		</div>';
				echo'		<nav class="navbar navbar-dark navbar_personalizzata">';
				echo'			<button class="navbar-toggler bottone_tendina" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" onclick="ruota(document.getElementById(\'tendina\'));">';
				echo'				<img class="rotate" id="tendina" src="../immagini/freccia_basso.png" style="width:30px;" >';
				echo'			</button>';
				echo'			<p class="grassetto" style="color:black;">Carica fascicoli</p>';
				echo'		</nav>';
				echo'	</div>';
				echo'</div>';




				echo'<div class="container-fluid corpo_centrale">';

				//echo '['.$archivio.']';
				if($archivio=="- seleziona archivio -")
				{
					$query_ricerca_presenti="SELECT numero, anno, modello, nome, e_in_archivio, data_di_archiviazione FROM `tabella_fascicoli` INNER JOIN tabella_archivi on legame_archivio=tabella_archivi.id WHERE e_in_archivio=1";
					$query_ricerca_assenti="SELECT numero, anno, modello, nome, e_in_archivio, data_uscita_archivio FROM `tabella_fascicoli` INNER JOIN tabella_archivi on legame_archivio=tabella_archivi.id WHERE e_in_archivio=0";

					echo'<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'	<h2 class="title titolo titolo_selezionato">Tutti i fascicoli</h2>';
					echo'</div>';

				}
				else
				{
					$query_ricerca_presenti="SELECT numero, anno, modello, nome, e_in_archivio, data_di_archiviazione FROM `tabella_fascicoli` INNER JOIN tabella_archivi on legame_archivio=tabella_archivi.id WHERE e_in_archivio=1 and nome='".$archivio."';";
					$query_ricerca_assenti="SELECT numero, anno, modello, nome, e_in_archivio, data_uscita_archivio FROM `tabella_fascicoli` INNER JOIN tabella_archivi on legame_archivio=tabella_archivi.id WHERE e_in_archivio=0 and nome='".$archivio."';";

					echo'<div class="col-md-6 offset-md-3 col-sm-12">';
					echo'	<h2 class="title titolo titolo_selezionato">'.$_POST["_carica_archivio"].'</h2>';
					echo'</div>';
				}

				$conn=connessione_db();
				$set_archivio_presenti=mysqli_query($conn,$query_ricerca_presenti);
				chiudi_connessione_db($conn);



				echo'<div class="row">';
				echo'	<div class="card-header	col-xl-10  offset-xl-1 col-sm-12 form_opzione" id="background_form_ricerca">';

				//presenti
				echo'<div class="card-header col-12 fascicolo_cercato_presente">';

				if($set_archivio_presenti -> num_rows != 0)
				{
					echo'	<div class="table-responsive-lg">';
					echo'		<table class="table table-striped">';
					echo'			<thead>';
					echo'				<tr class="table-primary">';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Numero</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Anno</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Modello</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Archivio</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Archiviazione</td>';
					echo'				</tr>';
					echo'			</thead>';
					echo'			<tbody>';
					while($riga_archivio_presenti= $set_archivio_presenti -> fetch_array())
					{
						echo'			<tr>';
						echo'				<td class="cella_tabella" style="text-align:left;">'.$riga_archivio_presenti['numero'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_presenti['anno'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_presenti['modello'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_presenti['nome'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_presenti['data_di_archiviazione'].'</td>';
						echo'			</tr>';
					}
					echo'			</tbody>';
					echo'		</table>';
					echo'	</div>';
				}
				else
					echo'<label class="label_standard col-12" style="text-align:center;"><strong>Non sono presenti fascicoli archiviati nell\'archivio</strong></label>';
				echo'</div>';


				//usciti
				$conn=connessione_db();
				$set_archivio_assenti=mysqli_query($conn,$query_ricerca_assenti);
				chiudi_connessione_db($conn);

				echo'<div class="card-header col-12 fascicolo_cercato_assente">';

				if($set_archivio_assenti -> num_rows != 0)
				{
					echo'	<div class="table-responsive-lg">';
					echo'		<table class="table table-striped">';
					echo'			<thead>';
					echo'				<tr class="table-primary">';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Numero</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Anno</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Modello</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Archivio</td>';
					echo'					<td scope="col" class="titolo_tabella" style="text-align:left;">Disarchiviazione</td>';
					echo'				</tr>';
					echo'			</thead>';
					echo'			<tbody>';
					while($riga_archivio_assenti= $set_archivio_assenti -> fetch_array())
					{
						echo'			<tr>';
						echo'				<td class="cella_tabella" style="text-align:left;">'.$riga_archivio_assenti['numero'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_assenti['anno'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_assenti['modello'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_assenti['nome'].'</td> <td class="cella_tabella" style="text-align:left;">'.$riga_archivio_assenti['data_uscita_archivio'].'</td>';
						echo'			</tr>';
					}
					echo'			</tbody>';
					echo'		</table>';
					echo'	</div>';
				}
				else
					echo'<label class="label_standard col-12" style="text-align:center;"><strong>Nessun fascicolo &egrave; uscito dall\'archivio</strong></label>';

				echo'</div>';

				$percorso="'../index.php'";
				echo'		<button class="btn btn-primary bottone_indietro_forms col-8 col-md-4 offset-2 offset-md-4" onclick="window.location.href='.$percorso.'" >Menu principale</button>';
				echo'	</div>';
				echo'</div>';
			}

		?>
	</body>
</html>
