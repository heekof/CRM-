<?php /* comptes.php */
require_once('lib/random.php');
require_once('lib/check.php');
require_once('lib/form.php');
require_once('lib/paging.php');
require_once('lib/element1.php');

function generate_account_form($editable)
{
	// Variables globales utilisées pour (pré)remplir le formulaire
	global $n, $idfacture, $password, $server, $codec, $destination, $date, $did, $lidc, $mesoffre;

	// Commence le formulaire en haut du tableau si tout est éditable
	if ($editable)
		echo '<form method="post" action="?page=comptes&amp;n='.$n.'&amp;a=update">';

	// Crée le tableau
	echo '<table class="form">';

	// Crée l'en-tête du tableau
	echo '<thead><tr><td colspan="2">';
	echo 'Compte n°'.$n;
	if (isset($date) && strlen($date) > 0)
		echo ' - '.$date;
	echo '</td></tr></thead>';

	// Ecrit le pied du tableau
	echo '<tfoot><tr><td colspan="2">';
	// Soit le formulaire est éditable, on ajoute le bouton modifier
	if ($editable)
		echo '<input type="submit" value="Modifier" />';
	// Soit le formulaire n'est pas éditable, on ajoute plusieurs butons: Editer, Voir facture
	else
	{
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="comptes" />'
			.'<input type="hidden" name="n" value="'.$n.'" />'
			.'<input type="hidden" name="a" value="edit" />'
			.'<input type="submit" value="Editer" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="facturation" />'
			.'<input type="hidden" name="spage" value="factures" />'
			.'<input type="hidden" name="f" value="'.$idfacture.'" />'
			.'<input type="hidden" name="a" value="details" />'
			.'<input type="submit" value="Voir la facture associ&eacute;e" />'
			.'</form>';
		{
			$rcpt = mysql_query("select * from compte where numero='$n';");
			$cpt = mysql_fetch_array($rcpt);
			if(!$cpt['clietranger']){
			
				if($cpt['forcrm']=='yes')
				echo '<form method="get" action="">'
					.'<input type="hidden" name="page" value="comptes" />'
					.'<input type="hidden" name="n" value="'.$n.'" />'
					.'<input type="hidden" name="a" value="deltocrm" />'
					.'<input type="submit" value="Retirer du crm" />'
					.'</form>';
				if($cpt['forcrm']=='no')
				echo '<form method="get" action="">'
					.'<input type="hidden" name="page" value="comptes" />'
					.'<input type="hidden" name="n" value="'.$n.'" />'
					.'<input type="hidden" name="a" value="addtocrm" />'
					.'<input type="submit" value="Affecter au crm" />'
					.'</form>';
			}
		}
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="comptes" />'
			.'<input type="hidden" name="n" value="'.$n.'" />'
			.'<input type="hidden" name="a" value="del" />'
			.'<input type="submit" value="Supprimer" />'
			.'</form>';
	}
	echo '</td></tr></tfoot>';

	// Ajoute le contenu du tableau
	echo '<tbody>';
	if (!$editable)
		insert_form_element('Login', 'text', 'login', $n, $editable);
	insert_form_element('Mot de passe', 'password', 'password', $password, $editable);
	insert_form_element('Serveur', 'text', 'server', $server, $editable);
	insert_form_element('Codec', 'text', 'codec', $codec, $editable);
	insert_form_element('Destination', 'text', 'destination', $destination, $editable);
	insert_form_element('Numéro externe', 'text', 'did', $did, $editable);
	
	//	cherche le propriétaire
	$query = " SELECT cl.nom AS nom, cl.prenom AS prenom, cl.numero AS numero FROM identite AS cl LEFT JOIN compte AS cp ON cl.numero = cp.idclient WHERE cp.numero = '$n' ;";
	$rClient = @mysql_query($query);
	$infosClient = @mysql_fetch_array($rClient);
	echo '<tr><td class="label">'.htmlentities('Propriétaire du compte').'</td>'.
	'<td class="input"><a href="?page=clients&a=details&c='.$infosClient['numero'].'">'.$infosClient['prenom'].' '.$infosClient['nom'].'</a></td></tr>';
	
//	insert_form_element('Destination', 'text', 'destination', $destination, $editable);
//   ajout tony
//  insert_form_element('Destination', 'text', 'destination', $destination, $editable);

	echo '</tbody>';

	// Termine le tableau
	echo '</table>';

	// Termine le forumulaire englobant si le tout était éditable
	if ($editable)
		echo '</form>';
}

// Initialisation des variables
$id = 0;
$count = 1;
$idabonnement = 0;
$idfacture = 0;
$password = '';
$server = '';
$codec = '';
$destination = '';
$date = '';
$did = '';

//echo $l;
// Id client
if (isset($_GET['c']))
	$c = (int)$_GET['c'];
else if (isset($c))
	unset($c);

// Id facture
if (isset($_GET['f']))
	$f = (int)$_GET['f'];
else if (isset($f))
	unset($f);

// Numéro de compte
if (isset($_GET['n']))
	$n = (int)$_GET['n'];
else if (isset($n))
	unset($n);

// Date filtre
if (isset($_GET['d']))
	$d = $_GET['d'];
else if (isset($d))
	unset($d);

// Transforme la date (d) en mois/annee
if (isset($d))
{
	$d = explode('/', $d);
	if (count($d) != 2)
		unset($d);
	else
	{
		$month = (int)$d[0];
		$year = (int)$d[1];

		if ($month < 1 || $month > 12 || $year < 0)
			unset($d);
	}
}

// Action
if (isset($_GET['a']))
	$a = strtolower($_GET['a']);
else
	$a = 'list';

// Actions:
// list: liste des comptes
// details: detail des comptes
// (re)edit: edition d'un comptes
// update: mise à jour d'un comptes
// new: creattion de nouveaux comptes (formulaire)
// add: creattion de nouveaux comptes (requete)
if ($a != 'list' && $a != 'details'
	&& $a != 'edit' && $a != 'update'
	&& $a != 'new' && $a != 'add' && $a != 'del'
	&& $a != 'addtocrm' && $a != 'deltocrm')
	$a = 'list';

if ($a == 'edit')
	$editable = true;
else
	$editable = false;
if ($a == 'del')
{
	// Test de validité beaucoup plus stricte pour la supression
	// Si la variable a est seulement définie en GET on demande confirmation
	// Si la variable a est aussi définie en POST, et que le numéro de compte est présent, on supprime ce compte
	if (isset($_POST['a']) && isset($_POST['n']) && $_POST['a'] == 'del' && $_POST['n'] > 0)
	{
		$n = (int)$_POST['n'];
	
		// Efface _toutes_ les données associées au compte, hormis le client
		// Modifier cette requete en cas de mise à jour de la base de données
		mysql_query('DELETE c, f '
			.'FROM compte AS c '
			.'LEFT JOIN facture AS f '
			.'ON c.idfacture = f.id '
			.'WHERE c.numero = \''.$n.'\';');
			
		unset($n);
		
		$a = 'list';
		$l = "all";
	}
	else if (!isset($n) || $n <= 0) // Retour direct à la liste pour les numéros invalides
	{
		unset($n);
		$a = 'list';
		$l = "all";
	}
}
else if ($a == 'add')
{
	$f = (int)$_POST['f'];
	$count = (int)$_POST['count'];
	$server = trim($_POST['server']);
	$codec = trim($_POST['codec']);
	$did = trim($_POST['did']);
	$lidc = (int)$_POST['lidc'];
	$destination = trim($_POST['destination']);
           //print("<br> lidc $lidc <br> ");
	$errors = array();
	//Vérifie qu'il existe une facture de tel numero
	$r_test1 = @mysql_query("SELECT * FROM compte WHERE  idfacture='$f'");
	$factureExiste = @mysql_num_rows($r_test1);
	
	//Vérifie qu'il existe un client avec l'id donné
	$r_test2 = @mysql_query("SELECT * FROM identite WHERE  numero='$lidc'");
	$clientExiste = @mysql_num_rows($r_test2);
	
		
	if ($f && !$factureExiste)
		$errors[] = 'Numéro de facture invalide';
	if ($count < 0)
		$errors[] = 'Nombre d\'éléments invalide';
	if (strlen($server) <= 0)
		$errors[] = 'Nom du serveur manquant';
	if (strlen($codec) <= 0)
		$errors[] = 'Nom du codec manquant';
	if (strlen($destination) <= 0)
		$errors[] = 'Destination manquante';
	if (!$clientExiste)
		$errors[] = 'Il n\'existe pas de client avec un tel identifiant';

	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		$a = 'new';
	}
	else // Ou insertions
	{
		// On lock d'abord la table pour s'assurer de générer des numéros de compte uniques
		// Ensuite on trouve le dernier numéro utilisé (MAX) et on utilise celui-ci pour en générer de nouveaux
		// Puis on crée les comptes avec les numéros correspondants
		// Et finalement, on libère le verrou
		if (mysql_query('LOCK TABLE compte WRITE;')
			&& ($r = mysql_query('SELECT MAX(numero) FROM compte;')))
		{
			if ($row = mysql_fetch_row($r))
				$min = $row[0] + 1; // Borne inclue
			else
				$min = 1; // Borne inclue

			$max = $min + $count; // Borne exclue
                          // $lidc = "33";
                          $Uneoffre = $mesoffre[$offre];
                          print("offre $Uneoffre <br> ");

			for ($i = $min; $i < $max; $i++)
				mysql_query('INSERT INTO compte (numero, password, idfacture, server, codec, destination,did, idclient,offre) '
					.'VALUES(\''.$i.'\', \''.random_password(5).'\', \''.$f.'\', \''.$server.'\', \''.$codec.'\', \''.$destination.'\',\''.$did.'\',\''.$lidc.'\',\''.$Uneoffre.'\');');
		}
		mysql_query('UNLOCK TABLES;'); // Libère les verrous

		$a = 'list';
	}
}
else if ($a == 'update')
{
	$password = trim($_POST['password']);
	$server = trim($_POST['server']);
	$codec = trim($_POST['codec']);
	$did = trim($_POST['did']);
	$destination = trim($_POST['destination']);

	$errors = array();

	if (strlen($server) <= 0)
		$errors[] = 'Nom du serveur manquant';
	if (strlen($codec) <= 0)
		$errors[] = 'Nom du codec manquant';
	if (strlen($destination) <= 0)
		$errors[] = 'Destination manquante';
	if (strlen($password) <= 0)
		$errors[] = 'Mot de passe manquant';

	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		$a = 'reedit';
	}
	else // Ou modification
		mysql_query('UPDATE compte SET '
			.'password = "'.$password.'" '
			.', server = "'.$server.'" '
			.', codec = "'.$codec.'" '
			.', did = "'.$did.'" '
			.', destination = "'.$destination.'" '
			.' WHERE numero = \''.$n.'\' ORDER BY id DESC LIMIT 1;');
}

// Choisit un titre à la page en fonction de l'affichage
if ($a == 'list')
	$title = 'Liste des comptes';
else if ($a == 'new')
	$title = 'Création de comptes';
else
{
	if ($a == 'edit' || $a == 'reedit')
		$title = 'Edition ';
	else
		$title = 'Détails ';

	if (isset($n))
		$title .= 'du compte n°'.$n;
	else
		$title .= 'des comptes';
}

if ($a == 'reedit')
	generate_account_form(true);
else if ($a == 'new')
{
	echo '<form method="post" action="?page=comptes&amp;a=add">';

	// Crée le tableau
	echo '<table class="form">';

	// Crée l'en-tête du tableau
	echo '<thead><tr><td colspan="2">Nouveaux comptes</td></tr></thead>';

	// Ecrit le pied du tableau
	echo '<tfoot><tr><td colspan="2">';
		echo '<input type="hidden" name="ldc" value="344" />';
	echo '<input type="submit" value="Valider" />';
	echo '</td></tr></tfoot>';



	// Ajoute le contenu du tableau
	echo '<tbody>';
	insert_form_element('Id facture', 'text', 'f', isset($f)?$f:'', true);
	insert_form_element('Nombre', 'text', 'count', $count, true);
	insert_form_element('Serveur', 'text', 'server', $server, true);
	insert_form_element('Codec', 'text', 'codec', $codec, true);
	insert_form_element('Destination', 'text', 'destination', $destination, true);
	insert_form_element('Offre', 'select', 'offre','titi','tata',$mesoffre);
		insert_form_element('Numéro externe', 'text', 'did', $did, true);
		insert_form_element('client', 'text', 'lidc', $lidc, true);
	echo '</tbody>';

	// Termine le tableau
	echo '</table>';

	// Termine le forumulaire englobant si le tout était éditable
	echo '</form>';
}
else if ($a == 'del')
{
	$title = 'Suppression d\'un compte';
	
	// Affiche simplement un message dissuasif
	echo '<div class="warning">'
		.'<div class="title">Attention !</div>'
		.'<p>Vous &ecirc;tes sur le point de supprimer le compte numéro '.$n.'.<br />'
		.'Cette op&eacute;ration est irr&eacute;versible.<br />'
		.'&Ecirc;tes vous certain de vouloir continuer ?</p>'
		.'<div class="buttons">'
		.'<form method="post" action="?page=comptes&amp;a=del">'
		.'<input type="hidden" name="a" value="del" />'
		.'<input type="hidden" name="n" value="'.$n.'" />'
		.'<input type="submit" value="Oui" />'
		.'</form>'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="comptes" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="hidden" name="n" value="'.$n.'" />'
		.'<input type="submit" value="Non" />'
		.'</form>'
		.'</div>'
		.'</div>';
}
else // Normalement seulement 'list' ou 'details' ici
{
	$where = ' WHERE 1 ';
	if(!isset($c))
	$where .= 'AND n.idfacture = f.id ';

	$base_url = '&a='.$a;

	// On filtre obligatoirement: soit par date soit par facture (ou par numéro seul)
	// Ensuite on peut filtrer par client (date), ou par numéro (date ou facture)

	// Gère le filtrage par client/facture et/ou numéro
	if (isset($f))
	{
		$where .= 'AND f.id = \''.$f.'\' ';
		$base_url .= '&f='.$f;
	}
	else if (isset($c))
	{
		$where .= 'AND n.idclient = \''.$c.'\' ';
		$base_url .= '&c='.$c;
	}
	if (isset($n))
	{
		$where .= 'AND n.numero = \''.$n.'\' ';
		$base_url .= '&n='.$n;
	}

	if ($a == 'list' || !isset($n))
	{
		// Tri par date disponible seulement pour les listes générales de comptes
		if (!isset($f))
		{
			// Obtient une liste des dates (mois, année) de factures
			$r = mysql_query('SELECT DISTINCT MONTH(f.date), YEAR(f.date) FROM compte AS n, facture AS f '.$where.'ORDER BY date DESC;');

			// Prend le mois en cours pour affichage si aucun n'était demandé
			if (!isset($d))
			{
				$d = getdate();

				$month = (int)$d['mon'];
				$year = (int)$d['year'];
			}
			if(!isset($c))
			// Rajoute à présent la partie date à la requete WHERE et à l'url de base pour les pages
			$where .= 'AND MONTH(f.date) = '.$month.' AND YEAR(f.date) = '.$year.' ';
			$base_url .= '&d='.$month.'%2F'.$year;
		}

		$r_p = mysql_query('SELECT COUNT(*) FROM compte AS n, facture AS f '.$where.';');
		if(isset($c))
			$r_p = mysql_query('SELECT COUNT(*) FROM compte AS n '.$where.';');
		if ($row = mysql_fetch_row($r_p))
			$page_count = page_count($row[0]);
		else
			$page_count = 1;
		$page = page_get($page_count);
		$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;

		$navbar = '<div class="navbar">'
			.'<div class="action"><a href="?page=comptes&amp;a=new">Créer des comptes</a></div>'
			.'<div class="action">'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="comptes" />'
			.'<input type="hidden" name="a" value="details" />'
			.'Voir le compte: '
			.'<input type="text" size="4" name="n" value="'.(isset($n)?$n:'').'" />'
			.'<input type="submit" value="Ok" />'
			.'</form>'
			.'</div>';
		// Construit le menu des dates
		if (!isset($f) && mysql_num_rows($r) >= 1)
		{
			$navbar .= '<div class="action">'
				.'<form method="get" action="">'
				.'<input type="hidden" name="page" value="comptes" />'
				.'<input type="hidden" name="a" value="'.$a.'" />';
			/*if (isset($c))
				$navbar .= '<input type="hidden" name="c" value="'.$c.'" />';*/
			$navbar .= 'Voir les comptes du mois: '
				.'<select name="d">';
			while ($row = mysql_fetch_row($r))
			{
				$date_month = (int)$row[0];
				$date_year = (int)$row[1];

				if (isset($d) && $date_month == $month && $date_year == $year)
					$date_selected = 'selected="selected" ';
				else
					$date_selected = '';

				$navbar .= '<option value="'.$date_month.'/'.$date_year.'"'.$date_selected.'>'.ucfirst(strftime('%B %Y', mktime(0, 0, 0, $date_month, 1, $date_year))).'</option>';
			}
			$navbar .= '</select>'
				.'<input type="submit" value="Ok" />'
				.'</form>'
				.'</div>';
			//On donne une valeur à $f pour pouvoir afficehr en fonction de la date
			//$f = 0;
		}
		$navbar .= '<div class="pages">Page: '.page_build_menu('?page=comptes'.$base_url.'&p=', $page, $page_count).'</div>'
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
	//Jean etienne : ici pour permettre de'afficher tous les comptes au cas où aucune condition n'est avoyée
	if(isset($l) && $l=="all")
		$account_query = " (SELECT n.id, n.numero, n.password, n.idfacture, n.server, n.codec, n.destination, '', n.did "
		."FROM compte AS n WHERE n.idfacture='0' ORDER BY n.id DESC ) UNION "
		.' (SELECT n.id, n.numero, n.password, n.idfacture, n.server, n.codec, n.destination, DATE_FORMAT(f.date, \'%d/%m/%Y\'), n.did '
		.'FROM compte AS n, facture AS f WHERE n.idfacture = f.id ORDER BY n.id DESC, f.date DESC ) ';
	else if(isset($c))
	$account_query = " (SELECT n.id, n.numero, n.password, n.idfacture, n.server, n.codec, n.destination, '', n.did "
		."FROM compte AS n ".$where." AND n.idfacture='0' ORDER BY n.id DESC) UNION "
		." (SELECT n.id, n.numero, n.password, n.idfacture, n.server, n.codec, n.destination, DATE_FORMAT(f.date, '%d/%m/%Y'), n.did "
		."FROM compte AS n, facture AS f ".$where." AND n.idfacture = f.id ORDER BY n.id DESC, f.date DESC) ";
	//Fin traitement affichage de tous les comptes
	else if(isset($n))
	$account_query = 'SELECT n.id, n.numero, n.password, n.idfacture, n.server, n.codec, n.destination, "", n.did '
		.'FROM compte AS n WHERE n.numero = \''.$n.'\'';
	else
	$account_query = 'SELECT n.id, n.numero, n.password, n.idfacture, n.server, n.codec, n.destination, DATE_FORMAT(f.date, \'%d/%m/%Y\'), n.did '
		.'FROM compte AS n, facture AS f '.$where.' ORDER BY n.id DESC, f.date DESC '	;
	
	//echo $where;/*A RETIRER*/
	if ($paging)
		$account_query .= ' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE;

	$account_query .= ';';

	if ($r = mysql_query($account_query))
	{
		echo $navbar;

		if ($a == 'list')
			echo '<table class="list"><thead><tr>'
				.'<td>N°</td><td>Num&eacute;ro externe</td><td>Serveur</td><td>Codec</td><td>Destination</td><td>Date</td><td>Action</td>'
				.'</tr></thead><tbody>';
		while ($row = mysql_fetch_row($r))
		{
			$id = (int)$row[0];
			$n = (int)$row[1];
			$password = $row[2];
			$idfacture = (int)$row[3];
			$server = $row[4];
			$codec = $row[5];
			$destination = $row[6];
			$date = $row[7];
			$did = $row[8];

			if ($a == 'list')
			{
				echo '<tr class="active"><td class="id">'.$n.'</td>';
				echo '<td class="text">'.htmlentities($did).'</td>';
				echo '<td class="text">'.htmlentities($server).'</td>';
				echo '<td class="text">'.htmlentities($codec).'</td>';
				echo '<td class="text">'.htmlentities($destination).'</td>';
				echo '<td class="date">'.htmlentities($date).'</td>';
				echo '<td class="action">';
				echo '<form method="get" action="">'
					.'<input type="hidden" name="page" value="comptes" />'
					.'<input type="hidden" name="n" value="'.$n.'" />';
				if (isset($f))
					echo '<input type="hidden" name="f" value="'.$f.'" />';
				else if (isset($d))
					echo '<input type="hidden" name="d" value="'.$month.'%2F'.$year.'" />';
				echo '<input type="hidden" name="a" value="details" />'
					.'<input type="submit" value="D&eacute;tails" />'
					.'</form>';
				echo '</td></tr>';
			}
			elseif($a == 'addtocrm' || $a == 'deltocrm'){
				
				echo '<center>manage compte for crm!!!!</center>';
				if($a == 'addtocrm'){
					mysql_query("update compte set forcrm='yes',server='crm.kt-centrex.com' where numero='$n';");
					echo "<center>Compte sip : $n affect&eacute; au crm avec succ&egrave;s!!!!</center>";
				}
				if($a == 'deltocrm'){
					mysql_query("update compte set forcrm='no',server='sip.kt-centrex.com' where numero='$n';");
					echo "<center>Compte sip : $n retir&eacute; du crm avec succ&egrave;s!!!!</center>";
				}
			}
			else
				generate_account_form($editable, true);
		}
		if ($a == 'list')
			echo '</tbody></table>';

		echo $navbar;
	}
	else
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
}
?>
