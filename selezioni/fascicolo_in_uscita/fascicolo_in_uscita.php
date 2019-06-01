<!DOCTYPE html>

<?php
	require_once("../../php/funzioni_php.php");
	controlla_login_token('../../login/login.php');
?>



<html>
	<head>
		<title>archivio v1.0</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="../../stili_css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nova+Square" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
		<script src="../../javascript/script.js"></script>
	</head>
	<body class="sfondo">

		<div class="pos-f-t" style="background:#ff2e2eb3;">
			<div class="col-md-6 offset-md-3 col-sm-12">
				<div class="collapse" id="navbarToggleExternalContent" style="text-align:center;">
					<div class="p-4 spazio_utente">
						<div class="center-cropped cropped_dimensioni_foto_profilo">
							<?php
								$la_foto=get_nome_foto_profilo($_SESSION['username']);
							?>
							
							<script>
								document.write('<img class="cropped_foto dimensione_foto_profilo" src="../../immagini/foto_profilo/<?=$la_foto?>?'+Math.random()+'" >');
							</script>
							
						</div>
						<div class="row">
							<h4 style="color:black; width:100%; text-align:center;"><?php echo $_SESSION['username'] ?></h4>
						</div>
						<div class="col-4 offset-4">
							<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href = '../../php/php_per_login/logout.php';">Log out</button>
						</div>
						<!--<span class="text-muted">eventuale descrizione</span>-->
					</div>
				</div>
				<nav class="navbar navbar-dark navbar_personalizzata">
					<button class="navbar-toggler bottone_tendina" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" onclick="ruota(document.getElementById('tendina'));">
						<img class="rotate" id="tendina" src="../../immagini/freccia_basso.png" style="width:30px;" >
					</button>
					<p class="grassetto" style="color:black;">Fascicolo in uscita</p>
				</nav>
			</div>
		</div>

		<div class="container-fluid corpo_centrale">
			<div class="col-md-6 offset-md-3 col-sm-12">
				<h2 class="title titolo titolo_selezionato">Uscita</h2>
			</div>
			
			
			<div class="row">
				<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">
					<div class="row">
						<div class="card-header	col-md-6 offset-md-3 col-sm-12 form_opzione" id="background_form_elimina">
							<form id="la_form" action='../../php/funzioni_post.php' method='post'>

								<div class="form-group col-md-8 offset-md-2">
									<label class="label_standard" >Numero</label>
									<input class="form-control form-control-md input_standard" id="numero" name="_numero" type="text">
								</div>

								<div class="form-group col-md-8 offset-md-2">
									<label class="label_standard" >Anno</label>
									<input class="form-control form-control-md input_standard" id="anno" name="_anno" type="text">
								</div>

								<div class="form-group col-md-8 offset-md-2">
									<label class="label_standard">Modello/Tipo</label>
									<select class="form-control form-control-md input_standard" id="select_modello" name="_select_modello">
										<option>- seleziona modello -</option>
										<option>21/Unico</option>
										<option>44/Ignoti</option>
										<option>45/Atti relativi</option>
										<option>21 bis/Giudice di pace</option>
									</select>

								</div>

								<input type="hidden" name="_scelta" value="uscita">

							</form>

							<div class="form-group col-md-8 offset-md-2 div_bottoni_forms">

								<div class="row">
									<button type="button"class="btn btn-primary col-5 col-sm-4 bottone_indietro_forms" onclick="window.location.href='../../index.php'">Indietro</button>
									<button class="btn btn-primary col-5 col-sm-4 offset-2 offset-sm-4 bottone_submit_forms" onclick="controllo_inputs(document.getElementById('numero'),document.getElementById('anno'),document.getElementById('select_modello'),'non controllare');">Elimina</button>

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>
