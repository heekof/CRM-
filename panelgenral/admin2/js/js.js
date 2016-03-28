
var i = 0;/* donne le nombre de passages dans le script. */
var duree = 604800;/* Dans le cas d'IE le script a tendance à réutiliser l'ancien résultat de le requete xmlhttp.open.
					cette variable rassure que cela ne peut arriver avant une semaine sans fermeture de la page.*/
function createXmlHttpRequestObject()
{
	//Création d'un objet boolean pour une instance valide d'IE
	var xmlhttp = false;
	//Test de l'usage d'IE.
	try {
		//Cas où la version de javascript est supérieur à 5.
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		//alert ("Vous utilisez Microsoft Internet Explorer.");
	} catch (e) {
		//Cas des autres Objets ActiveX.
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			//alert ("Vous utilisez Microsoft Internet Explorer.");
		} catch (E) {
			//Else we must be using a non-IE browser.
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
	xmlhttp = new XMLHttpRequest();
	//alert ("Vous utilisez Mozilla ou tout aute manigateur que Microsoft Internet Explorer");
	}
	return xmlhttp;
}
var cli;
/*Charge les fiches du client en cours d'appel
******************************************/
function chargement2(centrex2) 
{
	if(centrex2) 
		cli = centrex2;
	var xmlhttp = createXmlHttpRequestObject();
	var infosFiches = document.getElementById("infosFiches");
	if (xmlhttp.readyState == 4 || xmlhttp.readyState == 0)
	{
	
	xmlhttp.open("GET", "./scripts/chargeFicheClient2.php?centrex2="+cli,true);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4)
		{
			//l'état 200 indique que la transaction s'est effectuée avec succès
			if (xmlhttp.status == 200)
			{
				infosFiches.innerHTML = xmlhttp.responseText;
				setTimeout('chargement2()', 2000);
			}
			//Un état <> 200 signal une erreur
			else
			{
				alert("Il y a un problème dans l'acces au serveurs : " + xmlhttp.statusText);;
			}
		}
	}
	xmlhttp.send(null);
	}
	else{
		//Si la connesion n'es pas bonne, reéssayer après deux secondes
		setTimeout('chargement2()', 2000);
	}
}

/*
*******************************/
//Function to process an XMLHttpRequest.
function ajax (serverPage, obj, typeInsert, getOrPost, str){
	//Get an XMLHttpRequest object for use.
	xmlhttp = createXmlHttpRequestObject ();
	if (getOrPost == "get"){
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			if(typeInsert == "innerHTML")
			obj.innerHTML = xmlhttp.responseText;
			else if(typeInsert == "value")
			obj.value = xmlhttp.responseText;
		}
	}
	xmlhttp.send(null);
	} else {
		xmlhttp.open("POST", serverPage, true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
		xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			if(typeInsert == "innerHTML")
			obj.innerHTML = xmlhttp.responseText;
			else if(typeInsert == "value")
			obj.value = xmlhttp.responseText;
		}
		}
		xmlhttp.send(str);
	}
}


/* affiche cache la liste de types
**************************************************/
function checkOptions(form)
{	
	var msgErr = document.getElementById("msgErr");
	//return false;
	for(var i = 0; i < form.elements.length; i++){
		if(form.elements[i].type!="checkbox") continue;
		var checkb = form.elements[i];
		var label = document.getElementById("label"+checkb.value);
		var type = document.getElementById("type"+checkb.value);
		if(checkb.checked && (!label.value || type.options[type.selectedIndex].value=="choix"))
		{
			msgErr.innerHTML = "Pour chaque option cochée, veuillez renseigner le libel&eacute; et le type!";
			return false;
		}
	}
	return true;
}

/*Open hide fact adr
**********************************************/
function openHideInfoCli(op)
{
	var cliSansCpt = document.getElementById("cliSansCpt");
	var clicpt = document.getElementById("clicpt");
		
	if(op=='0')
	{
		cliSansCpt.style.display="none";
		clicpt.style.display="";
	}else if(op=='1')
	{
		cliSansCpt.style.display="";
		clicpt.style.display="none";
	}
	
}

function getPrixElement()
{
	var elements = document.getElementById("elements");
	var prixU = document.getElementById("prixU");
	//prixU.value = "123";
	var id = elements.options[elements.selectedIndex].value;
	var serverPage = "./scripts/prixElement.php?id="+id;
	ajax (serverPage, prixU, "value", "get");
}

function checkFormFact()
{
	var tva = parseInt(document.getElementById("tva").value);
	if(tva<0 || tva >100) 
	{
		alert('La TVA doit être entre 0 et 100!');
		return false;
	}
	return true;
}
//alert('bonjour!');