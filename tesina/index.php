<!DOCTYPE html>
<?php
	require_once("php/funzioni_php.php");
	controlla_login_token('login/login.php');



 ?>
 <!--versione 1.0-->
<!-- Collaboratore Tognoli -->
<html style="height:100%;">
	<head>
		<title>archivio v1.0</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="stili_css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nova+Square" rel="stylesheet">
		<script src="javascript/script.js"></script>
	</head>
	<body class="sfondo" style="height:100%;">



			<div class="pos-f-t" style="background:#ff8c00b3;">
				<div class="col-md-8 offset-md-2 col-sm-12">
					<div class="collapse" id="navbarToggleExternalContent" style="text-align:center;">
						<div class="p-4 spazio_utente">
							<div class="row">
								<img src="immagini/default_user.png" class="foto_utente" >
							</div>
							<div class="row">
								<h4 style="color:black; width:100%; text-align:center;"><?php echo $_SESSION['username'] ?></h4>
							</div>
							<!--<span class="text-muted">eventuale descrizione</span>-->
						</div>
					</div>
					<nav class="navbar navbar-dark navbar_personalizzata">
						<button class="navbar-toggler bottone_tendina" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" onclick="ruota(document.getElementById('tendina'));">
							<img class="rotate" id="tendina" src="immagini/freccia_basso.png" style="width:30px;" >
						</button>
						<p class="grassetto" style="color:black;">Archivio</p>
					</nav>
				</div>
			</div>


    	<h1 class="titolo">Maccarini Gestionale</h1>

		<div class="container-fluid corpo_centrale">
	 		<div class="row">


				<div class="col-md-3 offset-md-2 col-12 seleziona_opzione_posizionamento_esterno" id="fascicolo_entrata">
					<a href="selezioni/fascicolo_in_entrata/fascicolo_in_entrata.php" style="text-decoration:none;">
						<div class="seleziona_opzione_posizionamento_interno">
							<img src="immagini/fascicolo_entrata.png"  class="icona_opzione"/>
							<p class="testo_opzione">Fascicolo in entrata</p>
						</div>
					</a>
				</div>

	        	<div class="col-md-3 offset-md-2 col-12 seleziona_opzione_posizionamento_esterno" id="fascicolo_uscita">
					<a href="selezioni/fascicolo_in_uscita/fascicolo_in_uscita.php" style="text-decoration:none;">
						<div class="seleziona_opzione_posizionamento_interno">
							<img src="immagini/fascicolo_uscita.png"  class="icona_opzione" />
							<p class="testo_opzione">Fascicolo in uscita</p>
						</div>
					</a>
	        	</div>
	        </div>
			<div class="row">

				<div class="col-md-3 offset-md-2 col-12 seleziona_opzione_posizionamento_esterno" id="ricerca_fascicolo">
					<a href="selezioni/fascicoli/fascicoli.php" style="text-decoration:none;">
					<a href="selezioni/fascicoli/fascicoli.php" style="text-decoration:none;">
						<div class="seleziona_opzione_posizionamento_interno">
							<img src="immagini/fascicolo_cerca.png"  class="icona_opzione" />
							<p class="testo_opzione">fascicoli</p>
						</div>
					</a>
	        	</div>

	        	<div class="card-header	col-md-3 offset-md-2 col-12 seleziona_opzione_posizionamento_esterno" id="impostazioni">
					<a href="selezioni/impostazioni/impostazioni.php" style="text-decoration:none;">
						<div class="seleziona_opzione_posizionamento_interno">
							<img src="immagini/impostazioni.png" class="icona_opzione" />
							<p class="testo_opzione">Impostazioni</p>
						</div>
					</a>
				</div>

			</div>

		</div>

	</body>
</html>
