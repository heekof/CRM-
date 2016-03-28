<?php /* abonnements.php */
require_once('lib/check.php');
require_once('lib/abonnement.php');
require_once('lib/devis.php');
require_once('lib/check.php');
require_once('lib/date.php');
require_once('lib/form.php');
require_once('lib/paging.php');

// Initialisation des variables
$id = 0;
$debut = '';
$fin = '';

// Id Client
if (isset($_GET['c']))
	$c = (int)$_GET['c'];
else if (isset($c))
	unset($c);

// Id Facture
if (isset($_GET['f']))
	$f = (int)$_GET['f'];
else if (isset($f))
	unset($f);

// Id Abonnement
if (isset($_GET['s']))
	$s = (int)$_GET['s'];
else if (isset($s))
	unset($s);

// Id Element
if (isset($_GET['e']))
	$e = (int)$_GET['e'];
else if (isset($e))
	unset($e);

// Méthode de paiement (on détruit juste la variable)
if (isset($m))
	unset($m);

// Action
if (isset($_GET['a']))
	$a = strtolower($_GET['a']);
else
	$a = 'list';

// Actions:
// list: liste des éléments
// details: detail des éléments
// (re)edit: edition d'un élément
// update: mise à jour d'un élément
// create: création d'un abonnement
// togle: activation/desactivation d'un abonnement
// del: suppression d'un abonnement
// dateedit: modification des dates (formulaire)
// dateset: modification des dates (requete)
if ($a != 'list' && $a != 'details'
	&& $a != 'edit' && $a != 'update'
	&& $a != 'create' && $a != 'del'
	&& $a != 'toggle'
	&& $a != 'dateedit' && $a != 'dateset'&& $a != 'pay')
	$a = 'list';

// Gestion des actions de modification
// En général on redirige ensuite vers une action edition (en cas d'erreur) ou affichage (en cas de succès)
if ($a == 'del')
{
	// Test de validité beaucoup plus stricte pour la supression
	// Si la variable a est seulement définie en GET on demande confirmation
	// Si la variable a est aussi définie en POST, et que le numéro de client est présent, on supprime ce client
	if (isset($_POST['a']) && isset($_POST['s']) && $_POST['a'] == 'del' && $_POST['s'] > 0)
	{
		$s = (int)$_POST['s'];
	
		// Efface une facture de la base de données
		mysql_query('DELETE '
			.'FROM abonnementclients '
			.'WHERE numero = \''.$s.'\';');
		
		unset($s);
		
		$a = 'list';
	}
	else if (!isset($s) || $s <= 0) // Retour direct à la liste pour les numéros invalides
	{
		unset($s);
		$a = 'list';
	}
}
else if ($a == 'toggle')
{
	if (isset($s))
	{
		abonnement_changer_etat($s);
		unset($s);
	}
	$a = 'list';
}
else if ($a == 'create')
{
	// En cas d'erreur, on affichera la liste
	$a = 'list';
	// Vérifie avant tout que la facture est valide et qu'elle contient des éléments d'abonnement
	if (($r = mysql_query('SELECT COUNT(*) FROM elementfacture AS ef, element AS e WHERE idfacture = \''.$f.'\' AND ef.idelement = e.id AND e.type = 0;'))
		&& ($row = mysql_fetch_row($r))
		&& $row[0] > 0)
	{
		// Crée un nouvel abonnement à partir de la facture
		if (mysql_query('INSERT INTO abonnement (idfacture, idclient, debut, fin, etat)'
				.' SELECT id, idclient, NOW(), NOW() + INTERVAL 1 MONTH, \'off\' FROM facture'
				.' WHERE id = \''.$f.'\';'))
		{
			// Id du nouvel abonnement
			$s = mysql_insert_id();
			// Associe le nouvel abonnement à la facture
			mysql_query('UPDATE facture SET idabonnement = \''.$s.'\' WHERE id = \''.$f.'\';');
			// Ajoute les éléments à l'abonnement
			mysql_query('INSERT INTO elementabonnement (idabonnement, idelement, quantite, prix)'
				.' SELECT \''.$s.'\', ef.idelement, ef.quantite, ef.prix'
				.' FROM elementfacture AS ef, element AS e'
				.' WHERE ef.idfacture = \''.$f.'\' AND e.id = ef.idelement AND e.type = 0;');
			if (mysql_affected_rows() > 0)
				mysql_query('INSERT INTO mail (idenCli, idfacture, etat, nomsg) '
					.'SELECT f.idclient, f.id, \'no\', \'abonnementok\' '
					.'FROM facture AS f '
					.'WHERE f.id = \''.$f.'\';');
			// Affiche les détails du nouvel abonnement
			$a = 'details';
		}
	}
}
else if ($a == 'update')
{
	$errors = array();
	
	if ($q < 0)
		$errors[] = 'Impossible de spécifier une quantité négative';
	if ($p < 0)
		$errors[] = 'Impossible de spécifier un prix négatif';
	
	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		$a = 'reedit'; // On retourne au formulaire en cas d'erreur
	}
	else
	{
		abonnement_modifier_element($s, $e, $q, $p);
		$a = 'details';
	}
}
else if ($a == 'dateset')
{
	$debut = date_get($_POST['debut']);
	$fin = date_get($_POST['fin']);
	
	$errors = array();
	
	if (!$debut)
	{
		$errors[] = 'La date de début n\'est pas valide';
		$pr_debut = time();
	}
	if (!$fin)
	{
		$errors[] = 'La date de fin n\'est pas valide';
		$pr_fin = time();
	}
	
	if (date_diff($fin, $debut) <= 0)
		$errors[] = 'La date de fin doit être postérieure à la date de début';
		
	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		$a = 'datereedit'; // On retourne au formulaire en cas d'erreur
	}
	else
	{
		mysql_query('UPDATE abonnementclients '
			.'SET datedebut = \''.$debut.'\', dateecheance = \''.$fin.'\' '
			.'WHERE numero = \''.$s.'\';');
		$a = 'details';
	}
}
else if ($a == 'details' && !isset($s))
	$a = 'list';

// Préremplissage du formulaire d'édition d'un élément à l'aide de la base de données
if ($a == 'edit' || $a == 'reedit')
{
	// On cherche les valeurs dans la table facture ET dans la table client
	$r = mysql_query('SELECT e.ref, ea.quantite, ea.prix '
		.'FROM element e, elementabonnement ea '
		.'WHERE e.id = ea.idelement AND ea.idabonnement = \''.$s.'\' AND ea.idelement = \''.$e.'\';');
	
	if ($row = mysql_fetch_row($r))
	{
		$ref = $row[0];
		$quantite = (int)$row[1];
		$prix = (float)$row[2];
		
		$prix_unit = $prix / $quantite;
	}
	else
	{
		$quantite = 0;
		$prix = 0;
	}
	
	if ($a == 'reedit')
		$a = 'edit';
	else
	{
		$q = $quantite;
		$p = $prix;
	}
}
else if ($a == 'dateedit' && isset($s))
{
	$r = mysql_query('SELECT datedebut, dateecheance FROM abonnementclients WHERE numero = \''.$s.'\';');

	if ($row = mysql_fetch_row($r))
	{
		$debut = ($row[0]);
		$fin = ($row[1]);
		
		if (!$debut)
			$debut = time();
		if (!$fin)
			$fin = time();
	}
}
else if ($a == 'pay')
{
	// Methode de paiement
	if (isset($_GET['m']))
		$m = (int)$_GET['m'];
	else
		$m = 3;

	if ($m < 0 || $m > 3)
		echo '<p class="error">M&eacute;thode de paiement invalide.</p>';
	else if (isset($f))
		devis_valider_paiement($f, $m);
	$a = 'details';
}

if ($a == 'edit' || $a == 'new') // Formulaire d'édition ou création d'un élément
{
	if ($a == 'new')
	{
		$title = 'Ajout d\'un élément à l\'abonnement n°'.$s;
		$new = true;
	}
	else
	{
		$title = 'Edition d\'un élément de l\'abonnement n°'.$s;
		$new = false;
	}
	
	echo '<form method="post" action="?page=abonnements&amp;s='.$s.'&amp;e='.$e.'&amp;a='.($new?'add':'update').'">';
	echo '<table class="form">';
	echo '<thead><tr><td colspan="2">';
	echo 'Abonnement n°'.$s;
	echo '</td></tr></thead>';
	echo '<tfoot><tr><td colspan="2">'
		.'<input type="submit" value="Valider" />'
		.'</td></tr></tfoot>';
	echo '<tbody>';
	insert_form_element('Référence', 'text', 'ref', $ref, $new);
	insert_form_element('Prix unitaire', 'text', 'p', $prix_unit, $new);
	insert_form_element('Quantité', 'text', 'q', $q, true);
	if (!$new)
		insert_form_element('Prix total', 'text', 'p', $p, true);
	echo '</tbody>';
	echo '</table>';
}
else if ($a == 'del')
{
	$title = 'Suppression d\'un abonnement';
	
	// Affiche simplement un message dissuasif
	echo '<div class="warning">'
		.'<div class="title">Attention !</div>'
		.'<p>Vous &ecirc;tes sur le point de supprimer l\'abonnement numéro '.$s.'.<br />'
		.'Cette op&eacute;ration est irr&eacute;versible.<br />'
		.'&Ecirc;tes vous certain de vouloir continuer ?</p>'
		.'<div class="buttons">'
		.'<form method="post" action="?page=abonnements&amp;a=del">'
		.'<input type="hidden" name="a" value="del" />'
		.'<input type="hidden" name="s" value="'.$s.'" />'
		.'<input type="submit" value="Oui" />'
		.'</form>'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="abonnements" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="hidden" name="s" value="'.$s.'" />'
		.'<input type="submit" value="Non" />'
		.'</form>'
		.'</div>'
		.'</div>';
}
else if ($a == 'dateedit' || $a == 'datereedit')
{
	$title = 'Edition des dates';
	
	echo '<form method="post" action="?page=abonnements&amp;s='.$s.'&amp;a=dateset">';
	echo '<table class="form">';
	echo '<thead><tr><td colspan="2">';
	echo 'Abonnement n°'.$s;
	echo '</td></tr></thead>';
	echo '<tfoot><tr><td colspan="2">'
		.'<input type="submit" value="Valider" />'
		.'</td></tr></tfoot>';
	echo '<tbody>';
	insert_form_element('Date début', 'text', 'debut', date('d/m/Y', $debut), true);
	insert_form_element('Date fin', 'text', 'fin', date('d/m/Y', $fin), true);
	echo '</tbody>';
	echo '</table>';
}
else if ($a == 'list') // Vue liste des abonnements
{
	$title = 'Liste des abonnements';
	
	// Gère le filtrage par client (requete et url de la page)
	if (isset($c))
	{
		$where = 'WHERE idclient = \''.$c.'\' ';
		$base_url = '&c='.$c;
	}
	else
	{
		$where = '';
		$base_url = '';
	}
	
	// Gère la pagination
	$r = mysql_query('SELECT COUNT(*) FROM abonnementclients AS a '.$where.';');
	if ($row = mysql_fetch_row($r))
		$page_count = page_count($row[0]);
	else
		$page_count = 1;
	$page = page_get($page_count);
	$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;
	
	$navbar = '<div class="navbar">'
		.'<div class="action">'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="abonnements" />'
		.'<input type="hidden" name="a" value="details" />'
		.'Voir l\'abonnement: '
		.'<input type="text" size="4" name="s" value="'.(isset($s)?$s:'').'" />'
		.'<input type="submit" value="Ok" />'
		.'</form>'
		.'</div>'
		.'<div class="action">'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="abonnements" />'
		.'Voir les abonnements du client: '
		.'<input type="text" size="4" name="c" value="'.(isset($c)?$c:'').'" />'
		.'<input type="submit" value="Ok" />'
		.'</form>'
		.'</div>'
		.'<div class="pages">Page: '.page_build_menu('?page=abonnements'.$base_url.'&p=', $page, $page_count).'</div>'
		.'<hr />'
		.'</div>';
	
	// Génère la requête à éxécuter

 $query = 'SELECT numero,idclient,datedebut , dateecheance , montant,etat ,objet,idexterieur FROM abonnementclients  '.$where.' ORDER BY idclient ASC, numero DESC LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE.';';
	
	if ($r = mysql_query($query))
	{
		echo $navbar;
		
		echo '<table class="list"><thead><tr>'
			.'<td>Id</td><td>Id facture</td><td>Id client</td><td>Nom client</td><td>Nom produit</td><td>Date d&eacute;but</td><td>Date de fin</td><td>Prix</td><td>Etat</td><td>Action</td>'
			.'</tr></thead><tbody>';
		while ($row = mysql_fetch_row($r))
		{
			$id = (int)$row[0];
			$idc = (int)$row[1];
			$debut = $row[2];
			$fin = $row[3];
			$objet = $row[6];
			$facture = $row[7];
			$prix = (float)$row[4];
			if ($row[5] == 'on')
				$etat = true;
			else
				$etat = false;
			
	
			
$q= 'SELECT nom, prenom FROM identite WHERE numero ="'.$idc.'"';
$rb = mysql_query($q);
$obc = mysql_fetch_array($rb);
$nomcl=$obc['nom'];
$prenomcl=$obc['prenom'];
			
			
			
			
			if ($etat)
				echo '<tr class="active">';
			else
				echo '<tr class="inactive">';
				
			echo '<td class="id">'.$id.'</td>';
			echo '<td class="id">'.$facture.'</td>';
			echo '<td class="id">'.$idc.'</td>';
			echo '<td class="id">'.$nomcl.'   '.$prenomcl.'</td>';
			echo '<td class="id">'.$objet.'</td>';
			echo '<td class="date">'.date('d/m/Y', $debut).'</td>';
			echo '<td class="date">'.date('d/m/Y', $fin).'</td>';
			echo '<td class="total price">'.$prix.' €</td>';
			echo '<td class="info">'.($etat?'Actif':'Inactif').'</td>';
			echo '<td class="action">';
			echo '<form method="get" action="">'
				.'<input type="hidden" name="page" value="abonnements" />'
				.'<input type="hidden" name="s" value="'.$id.'" />'
				.'<input type="hidden" name="a" value="details" />'
				.'<input type="submit" value="D&eacute;tails" />'
				.'</form>';
			echo '<form method="get" action="">'
				.'<input type="hidden" name="page" value="abonnements" />'
				.'<input type="hidden" name="s" value="'.$id.'" />';
				if (isset($c))
					echo '<input type="hidden" name="c" value="'.$c.'" />';
			echo '<input type="hidden" name="a" value="toggle" />'
				.'<input type="submit" class="toggle" value="'.($etat?'D&eacute;sactiver':'Activer').'" />'
				.'</form>';
			echo '</td></tr>';
		}
		echo '</tbody></table>';
		
		echo $navbar;
	}
	else
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
}
else if ($a == 'details') // Vue détails d'un abonnement
{
	$title = 'Détails de l\'abonnement n°'.$s;
	
	// Récupéraction des informations d'abonnement
	
	if (!($r = mysql_query('SELECT numero, idclient, idexterieur,datedebut,dateecheance,montant, etat '
		.'FROM abonnementclients WHERE numero = \''.$s.'\' GROUP BY numero;')))
	{
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
		return;
	}
	
	if ($row = mysql_fetch_row($r))
	{
		$c = (int)$row[1];
		$f = (int)$row[2];
		$debut = $row[3];
		$fin = $row[4];
		$prix = (float)$row[5];
		$etat = (int)$row[6];
	}
	else
	{
		echo '<p class="error">Erreur MySQL.</p>';
		return;
	}
	
	// Affiche le récapitulatif
	echo '<div class="recap">';
	echo '<div class="info">Client n°'.$c.'</div>';
	echo '<div class="info">Dernière facture n°'.$f.'</div>';
	echo '<div class="info">Abonnement n°'.$s.'</div>';
	echo '<div class="info cat">D&eacute;but: '.date('d/m/Y', $debut).'</div>';
	echo '<div class="info">Fin: '.date('d/m/Y', $fin).'</div>';
	echo '<div class="price cat">Prix: '.$prix.' €</div>';
	echo '</div>';
	
$query = " SELECT * FROM facture where id = '".$f."'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$row = mysql_fetch_array($mysql_result);
$paiement=$row['paiement'];


	
	echo '<table class="list"><tfoot><tr>'
		.'<td colspan="6">';
	echo '<form method="get" action="">'
		.'<input type="hidden" name="page" value="clients" />'
		.'<input type="hidden" name="c" value="'.$c.'" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="submit" value="Voir les d&eacute;tails client" />'
		.'</form>';
	echo '<form method="get" action="">'
		.'<input type="hidden" name="page" value="facturation" />'
		.'<input type="hidden" name="spage" value="factures" />'
		.'<input type="hidden" name="f" value="'.$f.'" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="submit" value="Voir la derni&egrave;re facture" />'
		.'</form>';
	echo '<form method="get" action="">'
		.'<input type="hidden" name="page" value="abonnements" />'
		.'<input type="hidden" name="s" value="'.$s.'" />'
		.'<input type="hidden" name="a" value="dateedit" />'
		.'<input type="submit" value="Modifier les dates" />'
		.'</form>';
	echo '<form method="get" action="">'
		.'<input type="hidden" name="page" value="abonnements" />'
		.'<input type="hidden" name="s" value="'.$s.'" />'
		.'<input type="hidden" name="a" value="del" />'
		.'<input type="submit" value="Supprimer" />'
		.'</form>';
	if ($paiement == 1)
		{
	echo '<form method="get" action="">'
				.'<input type="hidden" name="page" value="abonnements" />'
				.'<input type="hidden" name="s" value="'.$s.'" />'
				.'<input type="hidden" name="f" value="'.$f.'" />'
				.'<input type="hidden" name="a" value="pay" />'
				.'<input type="submit" value="Valider le paiement" />';

			// Sélection méthode de paiement
	echo '<select name="m">';
	foreach ($devis_methodes as $methode => $nom_methode)
	echo '<option value="'.$methode.'">'.htmlentities($nom_methode).'</option>';
	echo '</select></form>';
		}
	echo '</td>'
		.'</tr></tfoot><tbody>';
	
	echo'</table>';
}

	
?>