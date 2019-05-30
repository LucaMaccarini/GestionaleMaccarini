<!DOCTYPE html>
<html>
	<head>
		<?php
			session_start();
			require_once('funzioni_php.php');
			controlla_login_token('../login/login.php');
		?>
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
		<script src="../javascript/script_ajax.js"></script>

	</head>
	
	<?php echo '<body class="sfondo" onload="pagina_fascicoli_presenti(\''.$_POST["_carica_archivio"].'\',1); pagina_fascicoli_assenti(\''.$_POST["_carica_archivio"].'\',1);">'?>
					
		<div class="pos-f-t" style="background:#efff00b3;">
			<div class="col-md-10 offset-md-1 col-sm-12">
				<div class="collapse" id="navbarToggleExternalContent" style="text-align:center;">
					<div class="p-4 spazio_utente">
						<div class="center-cropped cropped_dimensioni_foto_profilo" style="margin-bottom:10px;">
							<?php
								$la_foto=get_nome_foto_profilo($_SESSION['username']);
							?>
							
							<script>
								document.write('<img class="cropped_foto dimensione_foto_profilo" src="../immagini/foto_profilo/<?=$la_foto?>?'+Math.random()+'" >');
							</script>
							
							
						</div>
						<div class="row">
							<h4 style="color:black; width:100%; text-align:center;"><?php echo $_SESSION["username"]?></h4>
						</div>
						
						<div class="col-4 offset-4">
							<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href = 'php_per_login/logout.php';">Log out</button>
						</div>
					</div>
				</div>
				<nav class="navbar navbar-dark navbar_personalizzata">
					<button class="navbar-toggler bottone_tendina" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" onclick="ruota(document.getElementById(\'tendina\'));">
						<img class="rotate" id="tendina" src="../immagini/freccia_basso.png" style="width:30px;" onclick="ruota(document.getElementById('tendina'));" >
					</button>
					<p class="grassetto" style="color:black;">Carica fascicoli</p>
				</nav>
			</div>
		</div>




		<div class="container-fluid corpo_centrale">

			<div class="col-md-6 offset-md-3 col-sm-12">
				<h2 class="title titolo titolo_selezionato">
					<?php
						if($_POST["_carica_archivio"] == "- seleziona archivio -")
							echo 'Tutti i fascicoli';
						else
							echo $_POST["_carica_archivio"];
					?>
				</h2>
			</div>


				


		<div class="row">
			<div class="card-header	col-xl-10  offset-xl-1 col-sm-12 form_opzione" id="background_form_ricerca">

				<!--presenti-->
				<div class="card-header col-12 fascicolo_cercato_presente">

					<div class="table-responsive-lg">
						<table class="table table-striped">
							<thead>
								<tr class="table-primary">
									<td scope="col" class="titolo_tabella" style="text-align:left;">Numero</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Anno</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Modello</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Archivio</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Archiviazione</td>
								</tr>
							</thead>
							<tbody id="tabella_presenti">
							</tbody>
						</table>
					</div>
				
					<div class="row" style="margin-top:5px;">
						<div class="col-2 col-md-1 contenitore_freccia">
							<?php
								echo'<img class="pagina_sinistra" id="freccia_sinistra_presenti" style="display:none;" src="../immagini/freccia_cambio_pagina.png" onclick="pagina_fascicoli_presenti(\''.$_POST["_carica_archivio"].'\',parseInt(document.getElementById(\'pagina_presenti\').innerHTML) - 1); aggiorna_pagina(document.getElementById(\'pagina_presenti\'),parseInt(document.getElementById(\'pagina_presenti\').innerHTML) - 1)">';
							?>
						</div>
							
						<div class="col-2 offset-3 offset-sm-3 offset-md-4">
							<p class="n_pagina" id="pagina_presenti">1</p>
						</div>
						
						<div class="col-2 col-md-1  offset-3 offset-sm-3 offset-md-4 contenitore_freccia" >
							<?php
								echo'<img class="pagina_destra" id="freccia_destra_presenti" style="display:none;" src="../immagini/freccia_cambio_pagina.png" onclick="pagina_fascicoli_presenti(\''.$_POST["_carica_archivio"].'\',parseInt(document.getElementById(\'pagina_presenti\').innerHTML) + 1); aggiorna_pagina(document.getElementById(\'pagina_presenti\'), parseInt(document.getElementById(\'pagina_presenti\').innerHTML) + 1)">';
							?>
						</div>
					</div>
					
					
				</div>


				<!--//usciti-->
				
				<div class="card-header col-12 fascicolo_cercato_assente">

				
					<div class="table-responsive-lg">
						<table class="table table-striped">
							<thead>
								<tr class="table-primary">
									<td scope="col" class="titolo_tabella" style="text-align:left;">Numero</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Anno</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Modello</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Archivio</td>
									<td scope="col" class="titolo_tabella" style="text-align:left;">Disarchiviazione</td>
								</tr>
							</thead>
							<tbody  id="tabella_assenti">
							</tbody>
						</table>
			
					<!--<label class="label_standard col-12" style="text-align:center;"><strong>Nessun fascicolo &egrave; uscito dall\'archivio</strong></label>-->

					</div>
					
					<div class="row" style="margin-top:5px;">
						<div class="col-2 col-md-1 contenitore_freccia">
													
							<?php
								echo'<img class="pagina_sinistra" id="freccia_sinistra_assenti" style="display:none;" src="../immagini/freccia_cambio_pagina.png" onclick="pagina_fascicoli_assenti(\''.$_POST["_carica_archivio"].'\',parseInt(document.getElementById(\'pagina_assenti\').innerHTML) - 1); aggiorna_pagina(document.getElementById(\'pagina_assenti\'), parseInt(document.getElementById(\'pagina_assenti\').innerHTML) - 1)">';
							?>
						</div>
							
						<div class="col-2 offset-3 offset-sm-3 offset-md-4">
							<p class="n_pagina" id="pagina_assenti">1</p>
						</div>

						<div class="col-2 col-md-1  offset-3 offset-sm-3 offset-md-4 contenitore_freccia">
							<?php
								echo'<img class="pagina_destra"  id="freccia_destra_assenti" style="display:none;" src="../immagini/freccia_cambio_pagina.png" onclick="pagina_fascicoli_assenti(\''.$_POST["_carica_archivio"].'\',parseInt(document.getElementById(\'pagina_assenti\').innerHTML) + 1); aggiorna_pagina(document.getElementById(\'pagina_assenti\'), parseInt(document.getElementById(\'pagina_assenti\').innerHTML) + 1)">';
							?>
						</div>
					</div>
	
				</div>

				
				<button class="btn btn-primary bottone_indietro_forms col-8 col-md-4 offset-2 offset-md-4" onclick="window.location.href='../index.php'" >Menu principale</button>
			</div>
		</div>
			
	</body>
</html>
