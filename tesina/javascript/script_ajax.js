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
	var div_da_elimnare = document.getElementsByName("div_da_eliminare");
	var stringona="";
	for(var i=0; i<div_da_elimnare.length;i++)
	{
		stringona+=div_da_elimnare[i].childNodes[0].innerHTML;
		if(i!=div_da_elimnare.length-1)
			stringona+=",";
	}
    loadPage("../../ajax/rimuovi_archivi_ajax.php","_nomi_archivi_da_eliminare=" + stringona);
     
	if(req.responseText.includes("archivi non eliminati perchè contengono dei fascicoli archiviati:"))
	{
		alert(req.responseText.substring(req.responseText.indexOf("archivi non eliminati perchè contengono dei fascicoli archiviati:")));
	}
}

