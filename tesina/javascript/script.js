function abilita_disabilita(oggetto) 
{
	oggetto.disabled=!(oggetto.disabled);
}

function controllo_inputs(numero,anno,modello,archivio) 
{
	var passato=true;
	if(isNaN(numero.value) || numero.value.length<=0)
	{
		passato=false;
		alert("Hai inserito il campo 'Numero' in modo errato");
		numero.select();
	}
	else if (isNaN(anno.value) || anno.value.length!=4)
	{
		passato=false;
		alert("Hai inserito il campo 'Anno' in modo errato");
		anno.select();
	}
	else if (modello.selectedIndex<=0)
	{
		passato=false;
		alert("Non hai selezionato il campo 'Modello/Tipo'");
		modello.focus();
	}
	else if (archivio!= "non controllare")
	{
		if(archivio.selectedIndex<=0)
		{
			passato=false;
			alert("Non hai selezionato il campo 'archivio'");
			archivio.focus();
		}
	}
	
	if(passato)
	{
		//alert("Tutto ok");
		document.getElementById("la_form").submit();
		
		
		//problema checkbox non giusta quando si torna indietro
		if(archivio!= "non controllare")
		{
			archivio.selectedIndex=0;
		}		
	}
	
}

function visualizza_nascondi_impostazioni(stringa) 
{
	impostazione_corrente=document.getElementById(stringa);
	var lista_impostazioni = document.getElementsByClassName("impostazione_visualizza_nascondi");
	
	for(var i=0; i<lista_impostazioni.length; i++)
	{
		if(lista_impostazioni[i].id != impostazione_corrente.id && lista_impostazioni[i].style.display !="none")
			lista_impostazioni[i].style.display = "none";
	}
	
	if(impostazione_corrente.style.display == "none")
		impostazione_corrente.style.display = "block";
	
}

function seleziona_uno(event, stringa_classe_selezionato, stringa_classe_non_selezionato)
{
	impostazione_corrente=event;
	var lista_impostazioni = document.getElementsByClassName(stringa_classe_non_selezionato);
	var impostazione_selezionata = document.getElementsByClassName(stringa_classe_selezionato);
	
	
	if(impostazione_selezionata[0].id != impostazione_corrente.id)
	{
		impostazione_selezionata[0].className += " ";
		impostazione_selezionata[0].className += stringa_classe_non_selezionato;
		impostazione_selezionata[0].classList.remove(stringa_classe_selezionato);
		
		impostazione_corrente.className += " ";
		impostazione_corrente.className += stringa_classe_selezionato;
		impostazione_corrente.classList.remove(stringa_classe_non_selezionato);
	}
			
}

function seleziona_piu(event, stringa_classe_selezionato, stringa_classe_non_selezionato)
{
	impostazione_corrente=event;
	
	if(impostazione_corrente.classList.contains(stringa_classe_selezionato))
	{
		impostazione_corrente.className += " ";
		impostazione_corrente.className += stringa_classe_non_selezionato;
		impostazione_corrente.classList.remove(stringa_classe_selezionato);
		impostazione_corrente.removeAttribute("name");
	}
	else
	{
		impostazione_corrente.className += " ";
		impostazione_corrente.className += stringa_classe_selezionato;
		impostazione_corrente.classList.remove(stringa_classe_non_selezionato);
		impostazione_corrente.setAttribute("name","div_da_eliminare");
	}
			
}

/*function elimina_archivi_selezionati()
{
	var archivi_da_eliminare = document.getElementsByClassName("archivio_selezionato");
	var i=0;
	while(i<archivi_da_eliminare.length)
	{
		archivi_da_eliminare[i].parentElement.removeChild(archivi_da_eliminare[i]);
		//cancellare o nascondere archivio sul database
	}
			
}*/

function visualizza_nascondi_div_aggiungi_archivio() 
{
	var div_aggiungi_archivio=document.getElementById("div_aggiungi_archivio");
	var bottone= document.getElementById("nuovo_archivio");
	
	if(bottone.innerHTML=="Aggiungi")
	{
		div_aggiungi_archivio.style.display = "block";
		bottone.className += " bottone_indietro_forms";
		bottone.innerHTML="Nascondi";
	}
	else
	{
		div_aggiungi_archivio.style.display = "none";
		bottone.classList.remove("bottone_indietro_forms");
		bottone.innerHTML="Aggiungi";
	}
}

function controllo_select_archivi(componente_select)
{
	if(componente_select!="non_controllare")
	{
		if (componente_select.selectedIndex<=0)
		{
			alert("Non hai selezionato l'archivio da caricare!");
			componente_select.focus();
		}
		else
			document.getElementById("form_carica_archivi").submit();
	}
	else
		document.getElementById("form_carica_archivi").submit();
}



//script per login

function controllo_registrazione(la_form, username, primaPassword, ripetiPassword)
{
	if(username.value.length>0)
	{
		if(primaPassword.value.length>0)
		{
			if(ripetiPassword.value.length>0)
			{
				if(primaPassword.value === ripetiPassword.value)
					la_form.submit();
				else
				alert("Le password non coincidono");	
			}
			else
			alert("Inserire per la seconda volta la password");
		}
		else
			alert("Inserire la psssword");
	}
	else
		alert("Inserire l'username");
	
}


function controllo_login(la_form, username, primaPassword)
{
	if(username.value.length>0)
	{
		if(primaPassword.value.length>0)
			la_form.submit();
		else
			alert("Inserire la psssword");
	}
	else
		alert("Inserire l'username");
	
}

function ruota(tendina)
{
	if(tendina.classList.contains('down'))
		tendina.classList.remove("down");
	else
		tendina.classList.add("down");
}

