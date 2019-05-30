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
	
		<div class="pos-f-t" style="background:#ff8c00b3;">
			<div class="col-md-6 offset-md-3 col-sm-12">
				<nav class="navbar navbar-dark navbar_personalizzata">
					<p class="grassetto" style="color:black; width:100%; text-align:right;">Login errato</p>
				</nav>
			</div>
		</div>
		
		<div class="container-fluid corpo_centrale">
		
			<div class="col-md-6 offset-md-3 col-sm-12">
				<h2 class="title titolo titolo_selezionato" style="color:red;">Errore</h2>
			</div>


			<div class="row">
				<div class="card-header col-12 allineamento_spazzietto_destra_e_sinistra">
					<div class="row">
						<div class="card-header  col-lg-8 offset-lg-2	col-md-10 offset-md-1 col-sm-12 form_opzione" id="background_form_login">

							<div class="form-group col-md-8 offset-md-2">
								<?php
									if(isset($_GET['errore']))
									{
										if($_GET['errore']==1)
											echo'<label class="label_standard col-12" style="text-align:center;"><strong>Impossibile eseguire il login: username errato!</strong></label>';
										else
										{
											if($_GET['errore']==2)
												echo'<label class="label_standard col-12" style="text-align:center;"><strong>Impossibile eseguire il login: password errata!</strong></label>';	
										}
									}
									else
										echo'<label class="label_standard col-12" style="text-align:center;"><strong>Impossibile eseguire il login: credenziali errate!</strong></label>';
								?>
								<button class="btn btn-primary bottone_indietro_forms col-10 col-xl-6 offset-1 offset-xl-3" onclick="window.location.href='login.php'" >Torna al login</button>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</body>
</html>
