var req;

function loadPage(url, postvalue) {
   req = getAjaxControl();
   if(req) {
      req.open("POST", url, false); // sincrono
      req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
      req.send(postvalue);
      //alert(req.responseText);
   }
}

function getAjaxControl() {
   req = false;
   // branch for native XMLHttpRequest object
   if(window.XMLHttpRequest && !(window.ActiveXObject)) {
      try {
         req = new XMLHttpRequest();
      } catch(e) {
         req = false;
      }
   // branch for IE/Windows ActiveX version
   } else if(window.ActiveXObject) {
      try {
         req = new ActiveXObject("Msxml2.XMLHTTP");
      } catch(e) {
         try {
            req = new ActiveXObject("Microsoft.XMLHTTP");
         } catch(e) {
            req = false;
         }
      }
   }
   return req;
}

function ajax_get_json_nomi_archivi()
{
	var contenitore=document.getElementById("contenitore_tutti_archivi");
	loadPage("../../ajax/nomi_degli_archivi_ajax.php","");
    //alert(req.responseText);
    var result = JSON.parse(req.responseText);
    //alert(result);
    var i=1;
  	var stringona='<div class="row">';
    for(var k=0; k<result.length; k++)
    {
    	if(i==1)
				stringona+='<div class="card-header col-md-3 archivio" onclick="seleziona_piu(this, \'archivio_selezionato\', \'archivio\');">';
			else
				stringona+='<div class="card-header offset-md-1 col-md-3 archivio" onclick="seleziona_piu(this, \'archivio_selezionato\', \'archivio\');">';

			stringona+="<p class=\"testo_archivio\">" + result[k]['nome'] + "</p>";
			stringona+='</div>';
			if(i==3)
			{
				stringona+= '</div>';
				stringona+= '<div class="row">';
				i=0;
			}
			i++;
    }
    stringona+='</div></div>';
    contenitore.innerHTML=stringona;
}


function aggiungi_archivio()
{
	var nome_archivio=document.getElementById("nome_archivio");
    var form=document.getElementById("form_aggiungi_archivio");

    if(nome_archivio.value.length>0)
    {
    	loadPage("../../ajax/aggiungi_archivio_ajax.php","_nome_archivio=" + nome_archivio.value);
        if(req.responseText.includes("gia_esistente"))
        	alert("Nome archivio già utilizzato");
	}
    else
      alert("Inserire il nome dell' archivio");
}

function elimina_archivio()
{
  var stringa_non_eliminati;
	var div_da_elimnare = document.getElementsByName("div_da_eliminare");
	var stringona="";
	for(var i=0; i<div_da_elimnare.length;i++)
	{
		stringona+=div_da_elimnare[i].childNodes[0].innerHTML;
		if(i!=div_da_elimnare.length-1)
			stringona+=",";
	}
    loadPage("../../ajax/rimuovi_archivi_ajax.php","_nomi_archivi_da_eliminare=" + stringona);
    if(req.responseText != "")
    {
      var result = JSON.parse(req.responseText);
      stringa_non_eliminati=result[0];
      for (var i = 1; i < result.length; i++)
      {
        stringa_non_eliminati = stringa_non_eliminati + ", ";
        stringa_non_eliminati= stringa_non_eliminati + result[i];
      }
      alert("i seguenti archivi non sono stati eliminati perchè pieni:\n" + stringa_non_eliminati );
    }
    //alert(req.responseText);
}


function pagina_fascicoli_presenti(archivio,pagina)
{
	loadPage("../ajax/get_nomi_fascicoli_presenti.php","_nome_archivio=" + archivio +"&"+"_pagina="+pagina);
	if(req.responseText != "")
	{
		var tabella_presenti = document.getElementById("tabella_presenti");
		genera_righe_tabella_archivi(tabella_presenti);
	}
	
	var freccia_sinistra=document.getElementById('freccia_sinistra_presenti');
	if(pagina == 1)
	{
		
		freccia_sinistra.style.display="none";
	}
	else
		if(freccia_sinistra.style.display=="none")
			freccia_sinistra.style.display="inline-block";
		
	//alert(pagina);
	pagina=parseInt(pagina)+1;
	var freccia_destra=document.getElementById('freccia_destra_presenti');
	loadPage("../ajax/get_nomi_fascicoli_presenti_pagina_dopo.php","_nome_archivio=" + archivio +"&"+"_pagina="+pagina);
	
	//alert(req.responseText);
	if(req.responseText == "[]")
	{
		freccia_destra.style.display="none";
	}
	else
		if(freccia_destra.style.display=="none")
			freccia_destra.style.display="inline-block";
}


function pagina_fascicoli_assenti(archivio,pagina)
{
	loadPage("../ajax/get_nomi_fascicoli_assenti.php","_nome_archivio=" + archivio +"&"+"_pagina="+pagina);
	if(req.responseText != "")
	{
		var tabella_assenti = document.getElementById("tabella_assenti");
		genera_righe_tabella_archivi(tabella_assenti);
	}
	
	var freccia_sinistra=document.getElementById('freccia_sinistra_assenti');
	if(pagina == 1)
	{
		
		freccia_sinistra.style.display="none";
	}
	else
		if(freccia_sinistra.style.display=="none")
			freccia_sinistra.style.display="inline-block";
		
		
	pagina=parseInt(pagina)+1;
	var freccia_destra=document.getElementById('freccia_destra_assenti');
	loadPage("../ajax/get_nomi_fascicoli_assenti_pagina_dopo.php","_nome_archivio=" + archivio +"&"+"_pagina="+pagina);
	
	//alert(req.responseText);
	if(req.responseText == "[]")
	{
		freccia_destra.style.display="none";
	}
	else
		if(freccia_destra.style.display=="none")
			freccia_destra.style.display="inline-block";
}


function genera_righe_tabella_archivi(tabella)
{
	var result = JSON.parse(req.responseText);
	tabella.innerHTML="";
	for (var i = 0; i < result.length; i++)
	{
		var riga = document.createElement('tr');
		
		var numero = document.createElement('td');
		numero.style.textAlign = "left";
		numero.innerHTML=result[i]["numero"];
		numero.classList.add("cella_tabella");
		
		var anno = document.createElement('td');
		anno.innerHTML=result[i]["anno"];
		anno.style.textAlign = "left";
		anno.classList.add("cella_tabella");
		
		
		var modello = document.createElement('td');
		modello.innerHTML=result[i]["modello"];
		modello.style.textAlign = "left";
		modello.classList.add("cella_tabella");
		
		
		var archivio = document.createElement('td');
		archivio.innerHTML=result[i]["archivio"];
		archivio.style.textAlign = "left";
		archivio.classList.add("cella_tabella");
		
		
		var archiviazione = document.createElement('td');
		archiviazione.innerHTML=result[i]["data"];
		archiviazione.style.textAlign = "left";
		archiviazione.classList.add("cella_tabella");
		
		
		riga.appendChild(numero); 
		riga.appendChild(anno); 
		riga.appendChild(modello); 
		riga.appendChild(archivio); 
		riga.appendChild(archiviazione); 
		tabella.appendChild(riga); 
		//lert(result[i]["numero"]);
	}
}














