<?php
	if(file_exists ("../../login/registrazione_sbloccata.html"))
	{	
		rename("../../login/registrazione.html", "../../login/registrazione_bloccata.html");
		rename("../../login/registrazione_sbloccata.html", "../../login/registrazione.html");
		echo 'registrazione bloccata con successo!';
	}
	else
		echo 'registrazione già bloccata';
	


?>
