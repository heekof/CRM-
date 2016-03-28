//alert("Bonjour, nous faisons une petite maintenant!");
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
/*Charge les infos du client en cours d'appel
*****************************************/
function chargement(centrex2) 
{
	if(centrex2) 
		cli = centrex2;
	//Garde la reference de l'objet XMLHttpRequest
	var xmlhttp = createXmlHttpRequestObject();
	i++;/*Est incrémenté pour s'assurer de la mise à jour automatique de la page sans rechargement*/
	//ne procède que lorsque l'objet  xmlHttp est valide
	
	if (xmlhttp.readyState == 4 || xmlhttp.readyState == 0)
	{
	
	xmlhttp.open("GET", "./scripts/chargeFicheClient.php?centrex2="+cli,true);
	xmlhttp.onreadystatechange = function() {
		mise_a_jour(xmlhttp);
	}
	xmlhttp.send(null);
	}
	else
	//Si la connesion n'es pas bonne, reéssayer après deux secondes
	setTimeout('chargement()', 2000);
}

function mise_a_jour(xmlhttp)
{
	//N'avance que si la transaction est achvée
	if (xmlhttp.readyState == 4)
	{
		//l'état 200 indique que la transaction s'est effectuée avec succès
		if (xmlhttp.status == 200)
		{
			
			var text = xmlhttp.responseText;
			var tab = text.split('-');
			var zones = document.getElementsByTagName('span');
			//alert(text+cli);
			//Mise à jour de la page à partir des données du serveur
			var k=0;
			do{
				/*if(k==0)
				zones[k].innerHTML = "nom";
				else*/
				zones[k].innerHTML = tab[k];
				k++;
			}while(k<zones.length)
			//Recommance la séquence
			setTimeout('chargement()', 2000);
		}
		//Un état <> 200 signal une erreur
		else
		{
			alert("Il y a un problème dans l'acces au serveurs : " + xmlhttp.statusText);;
		}
	}
}

/*
*******************************/
//Function to process an XMLHttpRequest.
function ajax (serverPage, obj, getOrPost, str){
	//Get an XMLHttpRequest object for use.
	xmlhttp = createXmlHttpRequestObject ();
	if (getOrPost == "get"){
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			obj.innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.send(null);
	} else {
		xmlhttp.open("POST", serverPage, true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
		xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			obj.innerHTML = xmlhttp.responseText;
		}
		}
		xmlhttp.send(str);
	}
}
//alert("choix"+1);

/*Génère le zone de text pour les choix du QCM
*********************************************/
function checkbase()
{
	var xmlhttp = createXmlHttpRequestObject();
	var formBD = document.getElementById("formBD");
	var inputBase = document.getElementById("base");
	var msgdispo = document.getElementById("msgdispo");
	var zonemsg = document.getElementById("msgerreur");
	if(!inputBase.value)
	{	
		msgdispo.innerHTML = "";
		zonemsg.innerHTML = "Veuillez saisir le nom de votre base!!";
		return false
	}
	
	var serverPage = "./scripts/checkbase.php?nombase="+inputBase.value;
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var reponse = xmlhttp.responseText;
			//alert(reponse);
			if(reponse=='0')
			{
				msgdispo.innerHTML = "";
				zonemsg.innerHTML = "Ce nom de base est déjà pris!!";
				return false;
			}
			else if(reponse=='1')
			{
				/*zonemsg.innerHTML = "";
				msgdispo.innerHTML = "Nom de base disponible!!";*/
				formBD.submit();
				return true;
			}
		}
	}
	xmlhttp.send(null);
}
//alert("open close");
/*Ouvre ou ferme le conseil de la campagne
******************************************/
var ouvert = true;
function openCloseConseil()
{
	var leconseil = document.getElementById("leconseil");
	var openclose = document.getElementById("openclose");
	if(ouvert)
	{
		openclose.innerHTML = "Ouvrir";
		leconseil.style.display="none";
		ouvert = false;
		//alert("fermeture");

	}else{
		
		openclose.innerHTML = "Fermer";
		leconseil.style.display="";
		ouvert = true;
		//alert("ouverture");
	}
}
//***************************Voir form
function voirForm(num)
{
	var obj = document.getElementById("voirform");
	obj.innerHTML = "<img src='images/ajax.gif' />";
	var serverPage = "scripts/voirform.php?numero="+num;
	ajax (serverPage, obj, 'get');
}

function closeForm()
{
	var obj = document.getElementById("voirform");
	obj.innerHTML = "";
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
function checkList()
{
	var opt1 = document.getElementById('option1');
	var opt2 = document.getElementById('option2');
	var l1 = document.getElementById('typeoption1');
	var l2 = document.getElementById('typeoption2');
	if(opt1.checked)
	{
		var val1 = l1.options[l1.selectedIndex].value;
		if((val1 != "float") && (val1 != "varchar")) return false;
	}
	if(opt2.checked)
	{
		var val2 = l2.options[l2.selectedIndex].value;
		if((val2 != "float") && (val2 != "varchar")) return false;
	}
	return true;
}

/*Vérifie que le Login est bien inexistant
*****************************/
function checkLogin(lenumero)
{
	var xmlhttp = createXmlHttpRequestObject();
	var inputLogin = document.getElementById("inputLogin");
	var errLogin = document.getElementById("errLogin");
	if(!inputLogin.value)
	{	
		errLogin.innerHTML = "";
		errLogin.innerHTML = "Veuillez saisir un login!!";
		return false
	}
	if(lenumero)
		var serverPage = "scripts/checkLogin.php?login="+inputLogin.value+"&lenumero"+lenumero;
	else
		var serverPage = "scripts/checkLogin.php?login="+inputLogin.value;
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var reponse = xmlhttp.responseText;
			if(reponse=='0')
			{
				errLogin.innerHTML = "";
				errLogin.innerHTML = "Ce login est déjà pris!!";
				return false
			}
			if(reponse=='1')
			{
				errLogin.innerHTML = "";
				return true;
			}
		}
	}
	xmlhttp.send(null);
}

/*Vérifie l'unicité de nom de campagne
**********************************************/
function checkCamp()
{
	var xmlhttp = createXmlHttpRequestObject();
	var formCamp = document.getElementById("formCamp");
	var inputCamp = document.getElementById("inputCamp");
	var errCamp = document.getElementById("errCamp");
	var qcm = document.getElementById("qcm");
	var nbchoix = document.getElementById("nbchoix");
	var font_choix = document.getElementById("font_choix");
	errCamp.innerHTML = "";
	if(!inputCamp.value)
	{	
		errCamp.innerHTML = "Veuillez saisir un nom de campagne!!";
		return false;
	}
	if(qcm.checked && !nbchoix.value)
	{
		font_choix.style.color = "red";
		return false;
	}
	var serverPage = "scripts/checkCamp.php?camp="+inputCamp.value;
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var reponse = xmlhttp.responseText;
			
			if(reponse=="0")
			{
				errCamp.innerHTML = "";
				errCamp.innerHTML = "Ce nom de campagne est déjà pris!!";
				return false;
			}
			
			else if(reponse=="1")
			{
				//alert('deja');
				/*errCamp.innerHTML = "";*/
				formCamp.submit();
				return true;
			}
		}
	}
	xmlhttp.send(null);
}
//alert('deja');
/*Open hide fact adr
**********************************************/
function openHideFact(op)
{
	var trAdr = document.getElementById("factadr");
	var trCode = document.getElementById("factcode");
	var trVille = document.getElementById("factville");
	var trPays = document.getElementById("factpays");
		trAdr.style.display="";
		trCode.style.display="";
		trVille.style.display="";
		trPays.style.display="";
	if(op=='0')
	{
		trAdr.style.display="none";
		trCode.style.display="none";
		trVille.style.display="none";
		trPays.style.display="none";
	}else if(op=='1')
	{
		trAdr.style.display="";
		trCode.style.display="";
		trVille.style.display="";
		trPays.style.display="";
	}
	
}
/*Open hide liste des nums
**********************************************/
function openHideNums(op)
{
	var listeNums = document.getElementById("listeNums");
	var openClose = document.getElementById("openClose");
		listeNums.style.display="";
	if(op=='0')
	{
		listeNums.style.display="none";
		openClose.innerHTML='<a href="javascript:openHideNums(\'1\')"><font color="#996600">Ouvrir la liste de numéros</font></a>';
	}else if(op=='1')
	{
		listeNums.style.display="";
		openClose.innerHTML='<a href="javascript:openHideNums(\'0\')"><font color="#996600">Fermer la liste de numéros</font></a>';
	}
	
}

//Fonction aui controle le nombre de comte sip qu'on peut créer du coup
function limitNbrSip()
{
	var nbecompte = document.getElementById("nbecompte");
	
	if(nbecompte.value > 5) 
	{
		alert("Vous ne pouvez pas créer plus de 5 compte sip à la fois!");
		return false;
	}
	return true;
}
