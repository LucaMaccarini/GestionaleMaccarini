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
        <script src="../../javascript/script_ajax.js"></script>

	</head>
	<body class="sfondo" onload="ajax_get_json_nomi_archivi();">

		<div class="pos-f-t" style="background:#21d4ffb3;">
			<div class="col-xl-8 offset-xl-2 col-md-10 offset-md-1  col-sm-12">
				<div class="collapse" id="navbarToggleExternalContent" style="text-align:center;">
					<div class="p-4 spazio_utente">
						
							<?php
								$la_foto=get_nome_foto_profilo($_SESSION['username']);
							?>
							
							<script>
								document.write('<img class="cropped_foto dimensione_foto_profilo" src="../../immagini/foto_profilo/<?=$la_foto?>?'+Math.random()+'" >');
							</script>
							
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
					<p class="grassetto" style="color:black;">Impostazioni</p>
				</nav>
			</div>
		</div>
		

		<div class="container-fluid corpo_centrale">
			<div class="col-md-6 offset-md-3 col-sm-12">
				<h2 class="title titolo titolo_selezionato">Opzioni</h2>
			</div>

	 		<div class="row">
				<div class="card-header	col-md-10 col-xl-8 offset-xl-2 offset-md-1 col-sm-12 form_opzione allineamento_spazzietto_destra_e_sinistra">

					<div class="row">

						<div class="card-header col-md-3 form_opzione" id="background_form_impostazioni" style="margin-bottom:7px; height: 328px;">

							<div class="card-header col-md-12 background_form_impostazioni_voce_sinistra_selezionata" id="gestisci_archivi" onclick="visualizza_nascondi_impostazioni('impostazioni_archivi'); seleziona_uno(this, 'background_form_impostazioni_voce_sinistra_selezionata', 'background_form_impostazioni_voce_sinistra');">
								<p>archivi</p>
							</div>

							<div class="card-header col-md-12 background_form_impostazioni_voce_sinistra" id="Statistiche" onclick="visualizza_nascondi_impostazioni('impostazioni_account'); seleziona_uno(this, 'background_form_impostazioni_voce_sinistra_selezionata', 'background_form_impostazioni_voce_sinistra');">
								<p>Account</p>
							</div>

							<div class="card-header col-md-12 background_form_impostazioni_voce_sinistra" id="Info" onclick="visualizza_nascondi_impostazioni('impostazioni_info'); seleziona_uno(this, 'background_form_impostazioni_voce_sinistra_selezionata', 'background_form_impostazioni_voce_sinistra');">
								<p>Info</p>
							</div>

							<button type="button"class="btn btn-primary col-12 bottone_indietro_forms" style="margin-top:45px;" onclick="window.location.href='../../index.php'">indietro</button>
						</div>
						<div class="offset-md-1 col-md-8" style="padding:0px;">
							<div class="card-header form_opzione" id="background_form_impostazioni">

								<div id="impostazioni_archivi" class="impostazione_visualizza_nascondi">
									<div class="col-md-11 offset-md-1 allineamento_impostazioni">
										<div class="col-md-12" id="contenitore_tutti_archivi">
                                        	<!--autocompleamento degli archivi in ajax-->
                                        </div>

										<div class="row" id="div_aggiungi_archivio" style="display:none;">

											<div class="card-header col-md-11" id="aggiungi_archivio">
												<div class="form-group col-md-8 offset-md-2">
													<form id="form_aggiungi_archivio" action='impostazioni.php' method='post'>
														<label class="label_standard" >Nome</label>
														<input class="form-control form-control-md input_standard" id="nome_archivio" name="_nome_archivio" type="text" style="margin-bottom:5px;">
													</form>
													<button class="btn btn-primary col-5 offset-7 bottone_submit_forms" style="height: 35px;" onclick="aggiungi_archivio(); ajax_get_json_nomi_archivi();">Aggiungi</button>
												</div>

											</div>

										</div>


										<div class="row div_bottoni_forms" style="bottom:0px;">
											<button type="button" class="btn btn-primary col-5 col-md-4 bottone_indietro_forms" onclick="elimina_archivio(); ajax_get_json_nomi_archivi();">Elimina</button>
											<button class="btn btn-primary col-5 col-md-4 offset-2 offset-md-3 bottone_submit_forms" id="nuovo_archivio" onclick="visualizza_nascondi_div_aggiungi_archivio();">Aggiungi</button>
										</div>

									</div>
								</div>


								<div id="impostazioni_account" class="impostazione_visualizza_nascondi" style="display:none;">
									<div class="col-md-11 offset-md-1 allineamento_impostazioni">
									
										<div class="col-md-3" style="text-align:center;">
											<script>
												document.write('<img class="cropped_foto dimensione_foto_impostazioni" src="../../immagini/foto_profilo/<?=$la_foto?>?'+Math.random()+'" >');
											</script>
										</div>
										<div class="row">
											<div class="col-md-12" style="margin-top:15px">
												<p class="account_info">Username: <?php echo $_SESSION['username'] ?></p>
												<p class="account_info">Fascicoli archiviati: <?php get_numero_archiviati() ?></p>
												<p class="account_info">Fascicoli disarchiviati: <?php get_numero_disarchiviati() ?></p>
												
												<br>
												<form action="../../php/upload_image.php" method="post" enctype="multipart/form-data">
													
													<p class="account_info">Cambia foto profilo: </p> 
													<input type="file" class="account_upload" name="uploadedfile" style="width:100%; margin-bottom:8px" size="36">
													<input type="submit" class="btn btn-primary" value="Carica">
												
												</form>
											</div>
										</div>
									</div>
								</div>

								<div id="impostazioni_info" class="impostazione_visualizza_nascondi" style="display:none;">
									<div class="col-md-11 offset-md-1 allineamento_impostazioni">
										<h3 style="font-family: 'Nova Square', cursive;">Info:</h3>
										<p>applicazione svilupata da Luca Maccarini; release attuale 1.0</p>
									</div>
								</div>

							</div>
						</div>
					</div>

	        	</div>
			</div>
		</div>

	</body>
</html>
