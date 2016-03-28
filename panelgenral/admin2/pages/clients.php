<?php /* clients.php */
require_once('lib/random.php');
require_once('lib/check.php');
require_once('lib/form.php');
require_once('lib/comptes.php');
require_once('lib/paging.php');
function datePlus($dateDo,$nbrJours)
{
$timeStamp = strtotime($dateDo); 
$timeStamp += 24 * 60 * 60 * $nbrJours;
$newDate = date("Y-m-d", $timeStamp);
return  $newDate;
}

$datecreation=date("Y-m-d");
$daterelance=datePlus($datecreation,2);

function generate_client_form($editable, $update)
{
	// Variables globales utilisées pour (pré)remplir le formulaire
	global $id, $nom, $prenom, $societe,
		$adresse, $ville, $codepostal, $pays,
		$email, $telephonef, $telephonep, $telephoneb,
		$nickhandle, $password,
		$liv_adresse, $liv_codepostal, $liv_ville, $liv_pays;
	
	// Commence le formulaire en haut du tableau si tout est éditable
	if ($editable)
	{
		echo '<form method="post" action="?page=clients&amp;c='.$id.'&amp;a=';
		if ($update)
			echo 'update';
		else
			echo 'add';
		echo '">';
	}

	// Crée le tableau
	echo '<table class="form">';
	
	// Crée l'en-tête du tableau
	echo '<thead><tr><td colspan="2">';
	if (!$editable || $update)
		echo 'Client n°'.$id;
	else
		echo 'Nouveau client';
	echo '</td></tr></thead>';
	
	// Ecrit le pied du tableau
	echo '<tfoot><tr><td colspan="2">';
	// Soit le formulaire est éditable, on ajoute le bouton modifier
	if ($editable)
	{
		echo '<input type="submit" value="';
		if ($update)
			echo 'Modifier';
		else
			echo 'Créer';
		echo '" />';
	}
	// Soit le formulaire n'est pas éditable, on ajoute quatre butons: Editer, Factures, Abonnements, et Supprimer
	else
	{
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="clients" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="edit" />'
			.'<input type="submit" value="Editer" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="facturation" />'
			.'<input type="hidden" name="spage" value="factures" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="list" />'
			.'<input type="submit" value="Voir les factures" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="abonnements" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="list" />'
			.'<input type="submit" value="Voir les abonnements" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="comptes" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="list" />'
			.'<input type="submit" value="Voir les comptes" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="clients" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="del" />'
			.'<input type="submit" value="Supprimer" />'
			.'</form>';
	}
	echo '</td></tr></tfoot>';
	
	// Ajoute le contenu du tableau
	echo '<tbody>';
	insert_form_element('Nom', 'text', 'nom', $nom, $editable);
	insert_form_element('Prénom', 'text', 'prenom', $prenom, $editable);
	insert_form_element('Société', 'text', 'societe', $societe, $editable);
	insert_form_element('Adresse', 'text', 'adresse', $adresse, $editable);
	insert_form_element('Ville', 'text', 'ville', $ville, $editable);
	insert_form_element('Code Postal', 'text', 'codepostal', $codepostal, $editable);
	insert_form_element('Pays', 'text', 'pays', $pays, $editable);
	insert_form_element('E-Mail', 'text', 'email', $email, $editable);
	insert_form_element('Téléphone fixe', 'text', 'telephonef', $telephonef, $editable);
	insert_form_element('Téléphone portable', 'text', 'telephonep', $telephonep, $editable);
	insert_form_element('Téléphone bureau', 'text', 'telephoneb', $telephoneb, $editable);
	insert_form_element('Livraison: Adresse', 'text', 'liv_adresse', $liv_adresse, $editable);
	insert_form_element('Livraison: Code postal', 'text', 'liv_codepostal', $liv_codepostal, $editable);
	insert_form_element('Livraison: Ville', 'text', 'liv_ville', $liv_ville, $editable);
	insert_form_element('Livraison: Pays', 'text', 'liv_pays', $liv_pays, $editable);
	
	if (!$editable || $update) // Permet de voir/modifier les champs sauf dans le cas d'un nouvel utilisateur (générés automatiquement)
	{
		insert_form_element('Nickhandle', 'text', 'nickhandle', $nickhandle, $editable);
		insert_form_element('Mot de passe', 'password', 'password', $password, $editable);
	}
	echo '</tbody>';
	
	// Termine le tableau
	echo '</table>';
	
	// Termine le forumulaire englobant si le tout était éditable
	if ($editable)
		echo '</form>';
}

// Initialisation des variables
$id = 0;
$nom = '';
$prenom = '';
$societe = '';
$adresse = '';
$ville = '';
$codepostal = '';
$pays = '';
$email = '';
$telephonef = '';
$telephonep = '';
$telephoneb = '';
$nickhandle = '';
$password = '';
$liv_adresse = '';
$liv_codepostal = '';
$liv_ville = '';
$liv_pays = '';


// Id Client
if (isset($_GET['c']))
	$c = (int)$_GET['c'];
else if (isset($c))
	unset($c);

// Action
if (isset($_GET['a']))
	$a = strtolower($_GET['a']);
else
	$a = 'list';

if ($a != 'list' && $a != 'details' && $a != 'edit' && $a != 'update' && $a != 'new' && $a != 'add' && $a != 'toggle' && $a != 'del'&& $a != 'mail')
	$a = 'list';

if ($a == 'edit')
	$editable = true;
else
	$editable = false;

if ($a == 'toggle')
{
	if (isset($c))
	{
		mysql_query('UPDATE identite SET etat = (etat % 2) + 1 WHERE numero = \''.$c.'\';');
		$a = 'list';
		unset($c);
	}
}
if ($a == 'mail')
{

		$c = (int)$_GET['c'];

$query4 = " SELECT * FROM identite WHERE numero='".$_GET['cl']."'";
$mysql_result4 = mysql_query($query4) or die ("Erreur : ".mysql_error());
while($rowf = mysql_fetch_array($mysql_result4))
                              {
							          $nom = ($rowf["nom"]);
									  $prenom = ($rowf["prenom"]);
									  $email = ($rowf["email"]);
 }
 if (isset($_GET['send']))
{
$headers ='From: "KTcentrex.com" <support@ktcentrex.com>'."\n";
$headers .='Reply-To: support@ktcentrex.com'."\n";
$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';

$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";

						
						
$libelle = $_GET['editor1'];
$objet = $_GET['ob'];
$email = $_GET['email'];



$messageHTML = "<html><head><title></title></head><body>".stripslashes($libelle);
$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";
								     

$day=date("Y-m-d");
	//Fin enregistrement
	mysql_query('insert into mailstosend(email,objet,message,entete,idsignature) values("'.mysql_real_escape_string($email).'","'.stripslashes($objet).'","'.mysql_real_escape_string($messageHTML).'","'.mysql_real_escape_string($headers).'","'.$idsignature.'")') or die ("Erreur : ".mysql_error());

echo "<br><center><font color='green' size='4'>Mail  envoi&eacute; avec succ&egrave;!!!</font></center>";
}
?>
<script type="text/javascript" src="editeur/ckeditor.js"></script>
<script src="sample.js" type="text/javascript"></script>
<link href="sample.css" rel="stylesheet" type="text/css" />
<form action="" method="get"   >
<table width="%80" height="470" border="2" align="center" cellpadding="6" cellspacing="0">



<tr>
     <td> <b> Email d'envoie </b> </td>
     <td> <input type="text" name="email" size="20" id="dest" value="<?php echo $email;?>" />
	 &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
	Email de retour (test)  &nbsp; &nbsp; &nbsp;      
<input type="text" name="email1" size="30" value="support@ktcentrex.com" />
      </td>
</tr>



  <tr>
    <td><label for="editor1" style="font-family:verdana; font-size:11px;">Objet du mail:</label></td>
    <td><input class="ckeditor" style="width:355px;" id="ob" value="" name="ob"></td>
  </tr>

  <tr>
    <td height="335" colspan="2">

     <textarea class="ckeditor"  cols="10" id="editor1" name="editor1" rows="5"><?php echo $message;?></textarea>  </td>
  </tr>
  
 
  <tr>
        <input type="hidden" name="page" value="clients" />
	  <input type="hidden" name="cl" value="<?php echo $_GET['cl'];?>" />
	  <input type="hidden" name="a" value="mail" />
	  <input type="hidden" name="send" value="send" />
  <td><input type="submit" value="ENVOYER"   /></td>
  <td></td>
  </tr>

</table>

</form>
<?php
}
if ($a == 'del')
{
	// Test de validité beaucoup plus stricte pour la supression
	// Si la variable a est seulement définie en GET on demande confirmation
	// Si la variable a est aussi définie en POST, et que le numéro de client est présent, on supprime ce client
	if (isset($_POST['a']) && isset($_POST['c']) && $_POST['a'] == 'del' && $_POST['c'] > 0)
	{
		$c = (int)$_POST['c'];
	
		// Efface _toutes_ les données associées au client
		// Modifier cette requete en cas de mise à jour de la base de données
		mysql_query('DELETE i, f, a '
			.'FROM identite AS i '
			.'LEFT JOIN facture AS f '
			.'ON f.idclient = i.numero '
			.'LEFT JOIN abonnement AS a '
			.'ON a.idclient = i.numero '
			.'LEFT JOIN elementfacture AS ef '
			.'ON ef.idfacture = f.id '
			.'LEFT JOIN elementabonnement AS ea '
			.'ON ea.idabonnement = a.id '
			.'WHERE i.numero = \''.$c.'\';');
		
		unset($c);
		
		$a = 'list';
	}
	else if (!isset($c) || $c <= 0) // Retour direct à la liste pour les numéros invalides
	{
		unset($c);
		$a = 'list';
	}
}
else if ($a == 'update' || $a == 'add')
{
	$nom = trim($_POST['nom']);
	$prenom = trim($_POST['prenom']);
	$societe = trim($_POST['societe']);
	$adresse = trim($_POST['adresse']);
	$ville = trim($_POST['ville']);
	$codepostal = trim($_POST['codepostal']);
	$pays = trim($_POST['pays']);
	$email = trim($_POST['email']);
	$telephonef = trim($_POST['telephonef']);
	$telephonep = trim($_POST['telephonep']);
	$telephoneb = trim($_POST['telephoneb']);
	
	/**/
	if ($a == 'update')
	{
		$nickhandle = trim($_POST['nickhandle']);
		$password = trim($_POST['password']);
	}
	$liv_adresse = trim($_POST['liv_adresse']);
	$liv_codepostal = trim($_POST['liv_codepostal']);
	$liv_ville = trim($_POST['liv_ville']);
	$liv_pays = trim($_POST['liv_pays']);
	
	$errors = array();
	
	if (strlen($nom) <= 0)
		$errors[] = 'Nom incorrect ou manquant';
	if (strlen($prenom) <= 0)
		$errors[] = 'Prénom incorrect ou manquant';
	//if (strlen($societe) <= 0)
	//	$errors[] = 'Nom de société incorrect ou manquant';
	if (strlen($adresse) <= 0)
		$errors[] = 'Adresse incorrect ou manquante';
	if (strlen($ville) <= 0)
		$errors[] = 'Ville incorrecte ou manquante';
	if (!check_postal($codepostal))
		$errors[] = 'Code postal incorrect ou manquant';
	if (strlen($pays) <= 0)
		$errors[] = 'Pays incorrect ou manquant';
	if (!check_mail($email))
		$errors[] = 'E-mail incorrect ou manquant';
	if (!check_phone($telephonef))
		$errors[] = 'Téléphone fixe incorrect ou manquant';
	if (!check_phone($telephonep))
		$errors[] = 'Téléphone portable incorrect ou manquant';
	if (strlen($telephoneb) > 0 && !check_phone($telephoneb))
		$errors[] = 'Téléphone bureau incorrect';
	if ($a == 'update' && !isset($c))
		$errors[] = 'Numéro client non spécifié';
	if ($a == 'update')
	{
		if (strlen($nickhandle) <= 0)
			$errors[] = 'Nom d\'utilisateur incorrect ou manquant';
		if (strlen($password) <= 0)
			$errors[] = 'Mot de passe incorrect ou manquant';
	}
	// Si certains champs de l'adresse de livraison ne sont pas remplis, on les remplis avec l'adresse du client
	if (strlen($liv_adresse) <= 0)
		$liv_adresse = $adresse;
	if (strlen($liv_codepostal) <= 0)
		$liv_codepostal = $codepostal;
	else if (!check_postal($liv_codepostal))
		$errors[] = 'Code postal incorrect ou manquant pour l\'adresse de livraison';
	if (strlen($liv_ville) <= 0)
		$liv_ville = $ville;
	if (strlen($liv_pays) <= 0)
		$liv_pays = $pays;
	
	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		if ($a == 'update')
			$a = 'reedit';
		else if ($a == 'add')
			$a = 'new';
	}
	else if ($a == 'update') // Ou modification
		mysql_query('UPDATE identite SET '
			.'nom = "'.$nom.'" '
			.', prenom = "'.$prenom.'" '
			.', societe = "'.$societe.'" '
			.', adresse = "'.$adresse.'" '
			.', ville = "'.$ville.'" '
			.', codepostale = "'.$codepostal.'" '
			.', pays = "'.$pays.'" '
			.', email = "'.$email.'" '
			.', telephonef = "'.$telephonef.'" '
			.', telephonep = "'.$telephonep.'" '
			.', telephoneb = "'.$telephoneb.'" '
			.', nickhandle = "'.$nickhandle.'" '
			.', password = "'.$password.'" '
			.', liv_adresse = "'.$liv_adresse.'" '
			.', liv_codepostal = "'.$liv_codepostal.'" '
			.', liv_ville = "'.$liv_ville.'" '
			.', liv_pays = "'.$liv_pays.'" '
			.' WHERE numero = \''.$c.'\';');
	else // Ou insertion
	{
		// Génère un mot de passe aléatoire
		$password = random_password(10);
		// Crée un compte sans login
		mysql_query('INSERT INTO identite (nom, prenom, societe, adresse, ville, codepostale, pays, email, telephonef, telephonep, telephoneb, password, liv_adresse, liv_codepostal, liv_ville, liv_pays,date,nbrelance,daterelance) '
			.'VALUES("'.$nom.'"'
			.', "'.$prenom.'"'
			.', "'.$societe.'"'
			.', "'.$adresse.'"'
			.', "'.$ville.'"'
			.', "'.$codepostal.'"'
			.', "'.$pays.'"'
			.', "'.$email.'"'
			.', "'.$telephonef.'"'
			.', "'.$telephonep.'"'
			.', "'.$telephoneb.'"'
			.', "'.$password.'"'
			.', "'.$liv_adresse.'"'
			.', "'.$liv_codepostal.'"'
			.', "'.$liv_ville.'"'
			.', "'.$liv_pays.'"'
			.', "'.$datecreation.'"'
			.', "2"'
			.', "'.$daterelance.'");');
		$c = mysql_insert_id(); // Prend le nouvel id client à afficher
		// Génère un login aléatoire, et unique (avec l'id)
		$nickhandle = random_login(5).$c;
		// Met à jour la base de données avec le nouveau login
		mysql_query('UPDATE identite SET nickhandle="'.$nickhandle.'" WHERE numero = \''.$c.'\';');
		// On arrive sur la page de détails
		
		
		
		
		
		
		$a = 'details';
	}
}

// Choisit un titre à la page en fonction de l'affichage
if ($a == 'list')
	$title = 'Liste des clients';
if ($a == 'mail')
	$title = 'Envoyer un mail';
else if ($a == 'new')
	$title = 'Création d\'un nouveau client';
else
{
	if ($a == 'edit' || $a == 'reedit')
		$title = 'Edition ';
	else
		$title = 'Détails ';
	
	if (isset($c))
		$title .= 'du client n°'.$c;
	else
		$title .= 'des clients';
}

if ($a == 'reedit')
{
	$id = $c;
	generate_client_form(true, true);
}
else if ($a == 'new')
	generate_client_form(true, false);
else if ($a == 'del')
{
	$title = 'Suppression d\'un client';
	
	// Affiche simplement un message dissuasif
	echo '<div class="warning">'
		.'<div class="title">Attention !</div>'
		.'<p>Vous &ecirc;tes sur le point de supprimer le client numéro '.$c.'.<br />'
		.'Cette op&eacute;ration est irr&eacute;versible.<br />'
		.'&Ecirc;tes vous certain de vouloir continuer ?</p>'
		.'<div class="buttons">'
		.'<form method="post" action="?page=clients&amp;a=del">'
		.'<input type="hidden" name="a" value="del" />'
		.'<input type="hidden" name="c" value="'.$c.'" />'
		.'<input type="submit" value="Oui" />'
		.'</form>'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="clients" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="hidden" name="c" value="'.$c.'" />'
		.'<input type="submit" value="Non" />'
		.'</form>'
		
		.'</div>'
		.'</div>';
}
else
{
	if ($a == 'list' || !isset($c))
	{
		$r = mysql_query('SELECT COUNT(*) FROM identite;');
		if ($row = mysql_fetch_row($r))
			$page_count = page_count($row[0]);
		else
			$page_count = 1;
		$page = page_get($page_count);
		$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;
		
		$navbar = '<div class="navbar">'
			.'<div class="action"><a href="?page=clients&amp;a=new">Créer un nouveau client</a></div>'
			.'<div class="action">'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="clients" />'
			.'<input type="hidden" name="a" value="details" />'
			.'Voir le client: '
			.'<input type="text" size="4" name="c" value="'.(isset($c)?$c:'').'" />'
			.'<input type="submit" value="Ok" />'
			.'</form>&nbsp;&nbsp;'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="clients" />'
			.'<input type="hidden" name="a" value="list" />'
			.'Recherche de clients : '
			.'Nom<input type="radio" name="searchBy" value="nom" checked> '
			.'Prenom<input type="radio" name="searchBy" value="prenom"> '
			.'Soci&eacute;t&eacute;<input type="radio" name="searchBy" value="societe"> '
			.'Ville<input type="radio" name="searchBy" value="ville"> '
			.'Pays<input type="radio" name="searchBy" value="pays"> '
			.'<input type="text" name="searchKey" value="'.(isset($searchKey)?$searchKey:'').'" />'
			.'<input type="submit" value="Ok" />'
			.'</form>'
			.'</div><br>'
			.'<div class="pages">Page: '.page_build_menu('?page=clients&p=', $page, $page_count).'</div>'
			.'<hr />'
			.'</div>';
		
		// On doit prendre en compte le numéro de page
		$paging = true;
	}
	else
	{
		// Pas de barre de navigation
		$navbar = '';
		
		// On ne doit pas prendre en compte le numéro de page
		$paging = false;
	}
	
	$client_query = 'SELECT numero, nom, prenom, societe, adresse, ville, codepostale, pays, email, 
		telephonef, telephonep, telephoneb, nickhandle, password, liv_adresse,
		liv_codepostal, liv_ville, liv_pays, etat '
		.'FROM identite ';

	if (isset($c))
		$client_query .= 'WHERE numero = '.$c;
	
	if (isset($searchKey))
		$client_query .= 'WHERE '.$searchBy.' like "%'.$searchKey.'%" ';
	
	if ($paging)
		$client_query .= ' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE;
	
	$client_query .= ';';
	
	if ($r = mysql_query($client_query))
	{
		echo $navbar;
		
		if ($a == 'list')
			echo '<table class="list"><thead><tr>'
				.'<td>Id</td><td>Nom</td><td>Pr&eacute;nom</td><td>Soci&eacute;t&eacute;</td><td>Pays</td><td>T&eacute;l. fixe</td><td>T&eacute;l. portable</td><td>T&eacute;l. bureau</td><td>Nb comptes</td>
					<td>tarif premium</td><td>tarif wholesale</td><td>Action</td>'
				.'</tr></thead><tbody>';
		while ($row = mysql_fetch_row($r))
		{
			$id = (int)$row[0];
			$nom = $row[1];
			$prenom = $row[2];
			$societe = $row[3];
			$adresse = $row[4];
			$ville = $row[5];
			$codepostal = $row[6];
			$pays = $row[7];
			$email = $row[8];
			$telephonef = $row[9];
			$telephonep = $row[10];
			$telephoneb = $row[11];
			$nickhandle = $row[12];
			$password = $row[13];
			$liv_adresse = $row[14];
			$liv_codepostal = $row[15];
			$liv_ville = $row[16];
			$liv_pays = $row[17];
			

	
			
			if ($row[18] == 'on')
				$etat = true;
			else
				$etat = false;
			
			if ($a == 'list')
			{
$q = " SELECT COUNT(id) as num FROM facture WHERE idclient=$id ";
$result=mysql_query($q);
$total_facture = mysql_fetch_array($result);
$total_facture = $total_facture['num'];


			
$queryy = " SELECT * FROM facture , elementfacture WHERE elementfacture.idfacture=facture.id AND (prix < 2 OR paiement!=2) AND idclient=$id";
$mysql_resultyh = mysql_query($queryy) or die ("Erreur : ".mysql_error());
$cell= mysql_num_rows($mysql_resultyh);

				echo '<tr class="'.($etat?'active':'inactive').'"><td class="id">'.$id.'</td>';
				echo '<td>'.htmlentities($nom).'</td>';
				echo '<td>'.htmlentities($prenom).'</td>';
				echo '<td>'.htmlentities($societe).'</td>';
				echo '<td>'.htmlentities($pays).'</td>';
				echo '<td>'.htmlentities($telephonef).'</td>';
				echo '<td>'.htmlentities($telephonep).'</td>';
				echo '<td>'.htmlentities($telephoneb).'</td>';
				echo '<td align="right">'.nbComptes($id).'</td>';
				echo '<td class="action" style="width:320px;"><table style="border:none"><tr style="border:none">';
				if($cell > 0 or $total_facture==0){echo '<td style="border:none">&nbsp; <img src="images/alert.gif" height="23" style="position:relative;top:1px;">&nbsp; &nbsp;</td> ';}
				else{echo '<td style="border:none">&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td> ';}
				echo '<td style="border:none"><form method="get" action="">'
					.'<input type="hidden" name="page" value="clients" />'
					.'<input type="hidden" name="c" value="'.$id.'" />'
					.'<input type="hidden" name="a" value="details" />'
					.'<input type="submit" value="D&eacute;tails" />'
					.'</form></td>';
				echo '<td style="border:none"><form method="get" action="">'
					.'<input type="hidden" name="page" value="clients" />'
					.'<input type="hidden" name="c" value="'.$id.'" />'
					.'<input type="hidden" name="a" value="toggle" />'
					.'<input type="submit" class="toggle" value="'.($etat?'D&eacute;sactiver':'Activer').'" />'
					.'</form></td>';
					
			
						echo '<td style="border:none"><form method="get" action="">'
					.'<input type="hidden" name="page" value="clients" />'
					.'<input type="hidden" name="cl" value="'.$id.'" />'
					.'<input type="hidden" name="a" value="mail" />'
					.'<input type="submit" class="toggle" value="envoyer un mail" />'
					.'</form></td></tr></table>';
				echo '</td></tr>';
			}
			else
				generate_client_form($editable, true);
		}
		if ($a == 'list')
			echo '</tbody></table>';
		
		echo $navbar;
	}
	else
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
}
?>