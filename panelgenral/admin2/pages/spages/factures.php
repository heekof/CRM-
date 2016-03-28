<?php /* factures.php */
require_once('lib/check.php');
require_once('lib/devis.php');
require_once('lib/check.php');
require_once('lib/date.php');
require_once('lib/form.php');
require_once('lib/paging.php');

// Initialisation des variables avec leur valeur par défaut
$id = 0;
$type = '';
$ref = '';
$prix = '';
$nom = '';
$description = '';
$image = '';
$actif = 0;
$liv_adresse = '';
$liv_codepostal = '';
$liv_ville = '';
$liv_pays = '';
$ref = '';
$prix = 0;
$prix_unit = 0;
$p = 0;
$q = 0;
$pr = 1.0;
$mode = 0;

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

// Id Element
if (isset($_GET['e']))
	$e = (int)$_GET['e'];
else if (isset($e))
	unset($e);

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

// Méthode de paiement (on détruit juste la variable)
if (isset($m))
	unset($m);

// Action
if (isset($_GET['a']))
	$a = strtolower($_GET['a']);
else
	$a = 'list';

// Actions:
// list: liste des elements (affichage)
// details: detail des elements (affichage)
// (re)order: commande (formulaire)
// validate: validation commande (requete)
// pay: validation paiement (requete)
// (re)edit: edition d'un element (formulaire)
// update: mise à jour d'un element (requete)
// new: nouvel element de facture (element special, formulaire)
// add: ajout du nouvel element (requete)
// predit: modification du pro-rata (formulaire)
// prupdate: modification du pro-rata (requete)
// del: effacer une facture (formulaire + requete)
// mail: envoie un lien vers la facture au client (requete + affichage)
if ($a != 'list' && $a != 'details'
	&& $a != 'order' && $a != 'validate' && $a != 'pay'
	&& $a != 'edit' && $a != 'update' && $a != 'new' && $a != 'add'
	&& $a != 'predit' && $a != 'prupdate'
	&& $a != 'del'
	&& $a != 'mail')
	$a = 'list';

// Gestion des actions de modification
// En général on redirige ensuite vers une action edition (en cas d'erreur) ou affichage (en cas de succès)
if ($a == 'mail')
{
	if (isset($f) && $f > 0)
		mysql_query('INSERT INTO mail (idenCli, idfacture, etat, nomsg) '
			.'SELECT f.idclient, f.id, \'no\', \'devis\' '
			.'FROM facture AS f '
			.'WHERE f.id = \''.$f.'\';');
	else
		$a = 'list';
}
else if ($a == 'del')
{
	// Test de validité beaucoup plus stricte pour la supression
	// Si la variable a est seulement définie en GET on demande confirmation
	// Si la variable a est aussi définie en POST, et que le numéro de client est présent, on supprime ce client
	if (isset($_POST['a']) && isset($_POST['f']) && $_POST['a'] == 'del' && $_POST['f'] > 0)
	{
		$f = (int)$_POST['f'];

		// Efface une facture de la base de données
		mysql_query('DELETE '
			.'FROM facture '
			.'WHERE id = \''.$f.'\';');

		unset($f);

		$a = 'list';
	}
	else if (!isset($f) || $f <= 0) // Retour direct à la liste pour les numéros invalides
	{
		unset($f);
		$a = 'list';
	}
}
else if ($a == 'validate')
{
	$liv_adresse = $_POST['liv_adresse'];
	$liv_codepostal = $_POST['liv_codepostal'];
	$liv_ville = $_POST['liv_ville'];
	$liv_pays = $_POST['liv_pays'];
	if (isset($_POST['m']))
		$m = (int)$_POST['m'];
	else
		$m = 3;

	$errors = array();

	if ($m < 0 || $m > 3)
		$errors[] = 'Méthode de paiement invalide';

	if (strlen($liv_adresse) <= 0)
		$errors[] = 'Adresse manquante';
	if (strlen($liv_codepostal) <= 0)
		$errors[] = 'Code postal manquant';
	else if (!check_postal($liv_codepostal))
		$errors[] = 'Code postal invalide';
	if (strlen($liv_ville) <= 0)
		$errors[] = 'Ville manquante';
	if (strlen($liv_pays) <= 0)
		$errors[] = 'Pays manquant';

	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		$a = 'reorder';
	}
	else
	{
		devis_valider($f, $liv_adresse, $liv_codepostal, $liv_ville, $liv_pays, $m);
		$a = 'details';
	}
}
else if ($a == 'update')
{
	$q = (int)$_POST['q'];
	$p = (float)$_POST['p'];

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
		devis_modifier_element($f, $e, $q, $p);
		$a = 'details';
	}
}
else if ($a == 'add') // Ajout d'un élément spécial
{
	$ref = trim($_POST['ref']);
	$prix_unit = (float)$_POST['p'];
	$q = (int)$_POST['q'];
	$p = $prix_unit * $q;

	$errors = array();

	if (strlen($ref) <= 0)
		$errors[] = 'Référence manquante';
	if ($prix_unit < 0)
		$errors[] = 'Impossible de spécifier un prix négatif';
	if ($q < 0)
		$errors[] = 'Impossible de spécifier une quantité négative';

	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		$a = 'new'; // On retourne au formulaire en cas d'erreur
	}
	// Vérifie que l'on peut modifier la facture, puis ajoute l'élément
	else if (($r = mysql_query('SELECT * FROM facture WHERE id = \''.$f.'\' AND paiement = 0;'))
		&& mysql_num_rows($r) > 0)
	{
		if (mysql_query('INSERT INTO element (type, ref, prix, nom, actif) VALUES(\'2\', \''.$ref.'\', \''.$prix_unit.'\', \''.$ref.'\', 0);'))
		{
			$e = mysql_insert_id();

			mysql_query('INSERT INTO elementfacture (idfacture, idelement, quantite, prix) VALUES(\''.$f.'\', \''.$e.'\', \''.$q.'\', \''.$p.'\');');

			$a = 'details';
		}
	}
	else // On revient à la vue détaillée quoi qu'il arrive
		$a = 'details';
}
else if ($a == 'prupdate')
{
	$pr = (float)$_POST['pr'] / 100;
	$pr_debut = date_get($_POST['pr_debut']);
	$pr_fin = date_get($_POST['pr_fin']);
	//$mode = (int)$_POST['mode'];

	$errors = array();

	if ($pr <= 0)
		$errors[] = 'Le pro-rata doit être positif';
	else if ($pr > 1)
		$errors[] = 'Le pro-rata ne doit pas excéder 100';

	if (!$pr_debut)
	{
		$errors[] = 'La date de début n\'est pas valide';
		$pr_debut = time();
	}
	if (!$pr_fin)
	{
		$errors[] = 'La date de fin n\'est pas valide';
		$pr_fin = time();
	}

	if (date_diff($pr_fin, $pr_debut) <= 0)
		$errors[] = 'La date de fin doit être postérieure à la date de début';

	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		$a = 'prreedit'; // On retourne au formulaire en cas d'erreur
	}
	else
	{
		mysql_query('UPDATE facture '
			.'SET prorata = \''.$pr.'\', prorata_debut = \''.date_mysql_format($pr_debut).'\', prorata_fin = \''.date_mysql_format($pr_fin).'\' '
			.'WHERE id = \''.$f.'\';');
		mysql_query('UPDATE elementfacture AS ef, element AS e '
			.'SET ef.prorata = \''.$pr.'\' '
			.'WHERE ef.idfacture = \''.$f.'\' AND e.id = ef.idelement AND e.type = 0;');
		$a = 'details';
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
	$a = 'list';
}
else if ($a == 'details' && !isset($f))
	$a = 'list';

// Prépare au remplissage du formulaire (soit avec les anciennes valeurs, soit avec la bases de données)
if ($a == 'order')
{
	// On cherche les valeurs dans la table facture ET dans la table client
	$r = mysql_query('SELECT c.adresse, c.codepostale, c.ville, c.pays'
		.', c.liv_adresse, c.liv_codepostal, c.liv_ville, c.liv_pays'
		.', f.liv_adresse, f.liv_codepostal, f.liv_ville, f.liv_pays'
		.' FROM identite AS c, facture AS f'
		.' WHERE f.idclient = c.numero AND f.id = \''.$f.'\';');

	if ($row = mysql_fetch_row($r))
	{
		// On reconstitue l'adresse de livraison (dans l'ordre)
		// - Avec celle de la facture (si disponible)
		// - Avec celle du client (si disponible également)
		// - Avec l'adresse du client elle-même (normalement toujours disponible)

		// a - Adresse
		if (strlen($row[8]) > 0)
			$liv_adresse = $row[8];
		else if (strlen($row[4]) > 0)
			$liv_adresse = $row[4];
		else if (strlen($row[0]) > 0)
			$liv_adresse = $row[0];

		// b - Code Postal
		if (strlen($row[9]) > 0)
			$liv_codepostal = $row[9];
		else if (strlen($row[5]) > 0)
			$liv_codepostal = $row[5];
		else if (strlen($row[1]) > 0)
			$liv_codepostal = $row[1];
		
		// c - Ville
		if (strlen($row[10]) > 0)
			$liv_ville = $row[10];
		else if (strlen($row[6]) > 0)
			$liv_ville = $row[6];
		else if (strlen($row[2]) > 0)
			$liv_ville = $row[2];
		
		// d - Pays
		if (strlen($row[11]) > 0)
			$liv_pays = $row[11];
		else if (strlen($row[7]) > 0)
			$liv_pays = $row[7];
		else if (strlen($row[3]) > 0)
			$liv_pays = $row[3];
	}
}
else if ($a == 'reorder') // C'est le cas ou on reprend les anciennes valeurs (car la validation a échoué)
{
	// On change juste l'action en 'order'
	$a = 'order';
}

// Préremplissage du formulaire d'édition d'un élément à l'aide de la base de données
if ($a == 'edit' || $a == 'reedit')
{
	// On cherche les valeurs dans la table facture ET dans la table client
	$r = mysql_query('SELECT e.ref, ef.quantite, ef.prix '
		.'FROM element e, elementfacture ef '
		.'WHERE e.id = ef.idelement AND ef.idfacture = \''.$f.'\' AND ef.idelement = \''.$e.'\';');
	
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
else if ($a == 'predit' && isset($f))
{
	// On prend la valeur actuelle du prorata
	$r = mysql_query('SELECT prorata, DATE_FORMAT(prorata_debut, \'%d/%m/%Y\'), DATE_FORMAT(prorata_fin, \'%d/%m/%Y\') FROM facture WHERE id = \''.$f.'\';');

	if ($row = mysql_fetch_row($r))
	{
		$pr = (float)$row[0];
		$pr_debut = date_get($row[1]);
		$pr_fin = date_get($row[2]);
		
		if (!$pr_debut)
			$pr_debut = time();
		if (!$pr_fin)
			$pr_fin = time();
	}
}

// Gestion de l'affichage (mode commande, liste ou détails)
if ($a == 'mail')
{
	$title = 'Mail envoyé';
	
	echo '<div class="infobox">'
		.'<p>Le mail a été envoy&eacute; au client.</p>'
		.'<div class="buttons">'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="facturation" />'
		.'<input type="hidden" name="spage" value="factures" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="hidden" name="f" value="'.$f.'" />'
		.'<input type="submit" value="Retour aux détails" />'
		.'</form>'
		.'</div>'
		.'</div>';
}
else if ($a == 'order') // Formulaire de validation de commande
{
	$title = 'Validation du devis n°'.$f;

	if (!isset($m))
		$m = 3;
	
	echo '<form method="post" action="?page=facturation&amp;spage=factures&amp;f='.$f.'&amp;a=validate">';
	echo '<table class="form">';
	echo '<thead><tr><td colspan="2">';
	echo 'Facture n°'.$f;
	echo '</td></tr></thead>';
	echo '<tfoot><tr><td colspan="2">'
		.'<input type="hidden" name="m" value="'.$m.'" />'
		.'<input type="submit" value="Valider les param&egrave;tres" />'
		.'</td></tr></tfoot>';
	echo '<tbody>';
	insert_form_element('Adresse de livraison', 'text', 'liv_adresse', $liv_adresse, true);
	insert_form_element('Code postal', 'text', 'liv_codepostal', $liv_codepostal, true);
	insert_form_element('Ville', 'text', 'liv_ville', $liv_ville, true);
	insert_form_element('Pays', 'text', 'liv_pays', $liv_pays, true);
	echo '</tbody>';
	echo '</table>';
}
else if ($a == 'edit' || $a == 'new') // Formulaire d'édition ou création d'un élément
{
	if ($a == 'new')
	{
		$title = 'Ajout d\'un élément à la facture n°'.$f;
		$new = true;
	}
	else
	{
		$title = 'Edition d\'un élément de la facture n°'.$f;
		$new = false;
	}
	
	echo '<form method="post" action="?page=facturation&amp;spage=factures&amp;f='.$f.'&amp;e='.$e.'&amp;a='.($new?'add':'update').'">';
	echo '<table class="form">';
	echo '<thead><tr><td colspan="2">';
	echo 'Facture n°'.$f;
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
else if ($a == 'predit' || $a == 'prreedit') // Formulaire d'édition du pro-rata
{
	$title = 'Modification du pro-rata';
	
	echo '<form method="post" action="?page=facturation&amp;spage=factures&amp;f='.$f.'&amp;a=prupdate">';
	echo '<table class="form">';
	echo '<thead><tr><td colspan="2">';
	echo 'Facture n°'.$f;
	echo '</td></tr></thead>';
	echo '<tfoot><tr><td colspan="2">'
		.'<input type="submit" value="Valider" />'
		.'</td></tr></tfoot>';
	echo '<tbody>';
	insert_form_element('Pro-rata (%)', 'text', 'pr', number_format(100 * $pr, 3), true);
	//insert_form_element('Date du dernier paiement mensuel', 'text', 'pr_paiement', date('d/m/Y', $pr_paiement), true);
	//insert_form_element('Date du pro-rata', 'text', 'pr_debut', date('d/m/Y', $pr_debut), true);
	insert_form_element('Date de début du pro-rata', 'text', 'pr_debut', date('d/m/Y', $pr_debut), true);
	insert_form_element('Date de fin du pro-rata', 'text', 'pr_fin', date('d/m/Y', $pr_fin), true);
	//insert_form_element('Mode de fonctionnement', 'select', 'mode', $mode, true, array( 0 => 'Définir le pourcentage et les dates', 1 => 'Calculer le pourcentage à l\'aide des dates'));
	echo '</tbody>';
	echo '</table>';
}
else if ($a == 'del')
{
	$title = 'Suppression d\'une facture';
	
	// Affiche simplement un message dissuasif
	echo '<div class="warning">'
		.'<div class="title">Attention !</div>'
		.'<p>Vous &ecirc;tes sur le point de supprimer la facture ou le devis numéro '.$f.'.<br />'
		.'Cette op&eacute;ration est irr&eacute;versible.<br />'
		.'&Ecirc;tes vous certain de vouloir continuer ?</p>'
		.'<div class="buttons">'
		.'<form method="post" action="?page=facturation&amp;spage=factures&amp;a=del">'
		.'<input type="hidden" name="a" value="del" />'
		.'<input type="hidden" name="f" value="'.$f.'" />'
		.'<input type="submit" value="Oui" />'
		.'</form>'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="facturation" />'
		.'<input type="hidden" name="spage" value="factures" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="hidden" name="f" value="'.$f.'" />'
		.'<input type="submit" value="Non" />'
		.'</form>'
		.'</div>'
		.'</div>';
}
else if ($a == 'list') // Vue liste des factures
{
	$title = 'Liste des factures';
	
	$where = 'WHERE f.idclient > 0 ';
	$base_url = '';
	
	// Gère le filtrage par client (requete et url de la page)
	if (isset($c))
	{
		$where .= 'AND f.idclient = \''.$c.'\' ';
		$base_url .= '&c='.$c;
	}
	
	
	// Obtient une liste des dates (mois, année) de factures
	$r = mysql_query('SELECT DISTINCT MONTH(f.date), YEAR(f.date) FROM facture AS f '.$where.'ORDER BY date DESC;');
	
	// Rajoute à présent la partie date à la requete WHERE et à l'url de base pour les pages
	if (isset($d))
	{
		$where .= 'AND MONTH(f.date) = '.$month.' AND YEAR(f.date) = '.$year.' ';
		$base_url .= '&d='.$month.'%2F'.$year;
	}

	// Gère la pagination
	$r_p = mysql_query('SELECT COUNT(*) FROM facture AS f '.$where.';');
	if ($row = mysql_fetch_row($r_p))
		$page_count = page_count($row[0]);
	else
		$page_count = 1;
	$page = page_get($page_count);
	$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;
	
	$navbar = '<div class="navbar">'
		.'<div class="action"><a href="?page=facturation&amp;spage=newfacture&amp;a=new">Créer une facture</a>&nbsp;'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="facturation" />'
		.'<input type="hidden" name="spage" value="factures" />'
		.'<input type="hidden" name="a" value="details" />'
		.'Voir la facture: '
		.'<input type="text" size="4" name="f" value="'.(isset($f)?$f:'').'" />'
		.'<input type="submit" value="Ok" />'
		.'</form>'
		.'</div>'
		.'<div class="action">'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="facturation" />'
		.'<input type="hidden" name="spage" value="factures" />'
		.'Voir les factures du client: '
		.'<input type="text" size="4" name="c" value="'.(isset($c)?$c:'').'" />'
		.'<input type="submit" value="Ok" />'
		.'</form>'
		.'</div>';
	// Construit le menu des dates
	if (mysql_num_rows($r) >= 1)
	{
		$navbar .= '<div class="action">'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="facturation" />'
			.'<input type="hidden" name="spage" value="factures" />';
		if (isset($c))
			$navbar .= '<input type="hidden" name="c" value="'.$c.'" />';
		$navbar .= 'Voir les factures du mois: '
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
	}
	$navbar .= '<div class="pages">Page: '.page_build_menu('?page=facturation&amp;spage=factures'.$base_url.'&p=', $page, $page_count).'</div>'
		.'<hr />'
		.'</div>';
	
	// Génère la requête à éxécuter
	
	$facture_query = 'SELECT f.id, f.idclient, DATE_FORMAT(f.date, \'%d/%m/%Y - %H:%i:%s\'), '
		.'f.paiement, f.methode, '
		.'f.frais + SUM(ef.prix * ef.prorata), f.tva, f.prorata '
		.'FROM facture AS f LEFT JOIN elementfacture AS ef ON ef.idfacture = f.id '
		.$where
		.'GROUP BY f.id ORDER BY f.id DESC '
		.'LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE.';';

	if ($r = mysql_query($facture_query))
	{
		echo $navbar;
		
		echo '<table class="list"><thead><tr>'
			.'<td>Id</td><td>Id client</td><td>Date</td><td>Prix HT</td><td>Prix TTC</td><td>Pro-rata</td><td>Paiement</td><td>Action</td>'
			.'</tr></thead><tbody>';
		while ($row = mysql_fetch_row($r))
		{
			$id = (int)$row[0];
			$idc = (int)$row[1];
			$date = $row[2];
			$paiement = (int)$row[3];
			$methode = (int)$row[4];
			$prix = (float)$row[5];
			$tva = (float)$row[6];
			$pr = (float)$row[7];
			
			if ($paiement > 0)
				echo '<tr class="active">';
			else
				echo '<tr class="inactive">';
			echo '<td class="id">'.$id.'</td>';
			echo '<td class="id">'.$idc.'</td>';
			echo '<td class="date">'.$date.'</td>';
			echo '<td class="price">'.round($prix, 2).' €</td>';
			echo '<td class="total price">'.round($prix * (1 + $tva), 2).' €</td>';
			echo '<td class="info">'.(100 * $pr).' %</td>';
			echo '<td class="info">';
			echo htmlentities($devis_paiements[$paiement]);
			if ($paiement > 0)
				echo ': '.htmlentities($devis_methodes[$methode]);
			echo '</td>';
			echo '<td class="action">';
			echo '<form method="get" action="">'
				.'<input type="hidden" name="page" value="facturation" />'
				.'<input type="hidden" name="spage" value="factures" />'
				.'<input type="hidden" name="f" value="'.$id.'" />'
				.'<input type="hidden" name="a" value="details" />'
				.'<input type="submit" value="D&eacute;tails" />'
				.'</form>';
			echo '</td></tr>';
		}
		echo '</tbody></table>';
		
		echo $navbar;
	}
	else
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
}
else if ($a == 'details') // Vue détails d'une facture
{
	$title = 'Détails de la facture n°'.$f;
	
	// Récupéraction des informations de facture
	// Pour la récupération des prix totaux: on sépare entre prix mensuels et autres prix pour le pro-rata...
	if (!($r = mysql_query('SELECT f.idclient, DATE_FORMAT(f.date, \'%d/%m/%Y - %H:%i:%s\'), '
		.'f.paiement, f.methode, '
		.'SUM(ef.prix * ef.prorata), f.tva, '
		.'f.liv_adresse, f.liv_codepostal, f.liv_ville, f.liv_pays, '
		.'f.frais, DATE_FORMAT(f.date_paiement, \'%d/%m/%Y - %H:%i:%s\'), f.idabonnement, '
		.'f.prorata, DATE_FORMAT(f.prorata_debut, \'%d/%m/%Y\'), DATE_FORMAT(f.prorata_fin, \'%d/%m/%Y\') '
		.'FROM facture AS f LEFT JOIN elementfacture AS ef '
		.'ON ef.idfacture = f.id WHERE f.id = \''.$f.'\' GROUP BY f.id;')))
	{
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
		return;
	}
	
	if ($row = mysql_fetch_row($r))
	{
		$c = $row[0];
		$date = $row[1];
		$paiement = $row[2];
		$methode = $row[3];
		$prix = (float)$row[4];
		$tva = (float)$row[5];
		
		$liv_adresse = $row[6];
		$liv_codepostal = $row[7];
		$liv_ville = $row[8];
		$liv_pays = $row[9];

		$frais = (float)$row[10];
		$date_paiement = $row[11];
		
		// Id abonnement associé
		$s = (int)$row[12]; // (0 si NULL)
		
		// Pro rata (pour les factures partielles)
		$pr = (float)$row[13];
		$pr_debut = $row[14];
		$pr_fin = $row[15];
	}
	else
	{
		echo '<p class="error">Erreur MySQL.</p>';
		return;
	}

	// Affiche le récapitulatif
	echo '<div class="recap">';
	echo '<div class="info">Client n°'.$c.'</div>';
	echo '<div class="info">Facture n°'.$f.'</div>';
	echo '<div class="info">Cr&eacute;ation: '.$date.'</div>';
	echo '<div class="info cat">Pro rata: '.(100 * $pr).' %';
	if ($pr < 1) // Si le prorata est défini, on affiche les dates
		echo ' (D&eacute;but: '.$pr_debut.', Fin: '.$pr_fin.')';
	echo '</div>';
	echo '<div class="price cat">Frais de pr&eacute;paration: '.$frais.' € HT</div>';
	$prix = $prix + $frais;
	echo '<div class="price">Prix HT: '.round($prix, 2).' € HT</div>';

	if (strlen($liv_adresse) > 0)
	{
		echo '<div class="info cat">Adresse de livraison: </div>';
		echo '<div class="address">'.htmlentities($liv_adresse).'<br />';
		echo htmlentities($liv_codepostal.' '.$liv_ville).'<br />';
		echo htmlentities($liv_pays);
		echo '</div>';
	}
	echo '<div class="info cat">TVA ('.(100 * $tva).' %): '.round($prix * $tva, 2).' €</div>';
	echo '<div class="price">Prix TTC: '.round($prix * (1 + $tva), 2).' € TTC</div>';
	if ($paiement >= 2)
		echo '<div class="info cat">Pay&eacute; le '.$date_paiement.', '.$devis_methodes[$methode].'</div>';
	echo '</div>';

	$facture_query = 'SELECT e.id, e.ref, ef.quantite, ef.prix, e.type '
		.'FROM element e, elementfacture ef '
		.'WHERE e.id = ef.idelement AND ef.idfacture = \''.$f.'\' AND ef.quantite > 0;';

	if (!($r = mysql_query($facture_query)))
	{
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
		return;
	}

	echo '<table class="list"><thead><tr>'
		.'<td>Id</td><td>R&eacute;f&eacute;rence</td><td>Quantit&eacute;</td><td>Prix unitaire</td><td>Prix total</td><td>Prix au pro-rata</td><td>Action</td>'
		.'</tr></thead><tfoot><tr>'
		.'<td colspan="7">';
	echo '<form method="get" action="">'
		.'<input type="hidden" name="page" value="clients" />'
		.'<input type="hidden" name="c" value="'.$c.'" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="submit" value="Voir les d&eacute;tails client" />'
		.'</form>';
	echo '<form method="get" action="">'
		.'<input type="hidden" name="page" value="facturation" />'
		.'<input type="hidden" name="spage" value="factures" />'
		.'<input type="hidden" name="a" value="mail" />'
		.'<input type="hidden" name="f" value="'.$f.'" />'
		.'<input type="submit" value="Envoyer un mail au client" />'
		.'</form>';
	// Affiche des options en fonction de l'état du paiement
	if ($paiement <= 1)
	{
		if ($paiement == 0)
		{
			echo '<form method="get" action="">'
				.'<input type="hidden" name="page" value="facturation" />'
				.'<input type="hidden" name="spage" value="factures" />'
				.'<input type="hidden" name="f" value="'.$f.'" />'
				.'<input type="hidden" name="a" value="new" />'
				.'<input type="submit" value="Ajouter un &eacute;l&eacute;ment sp&eacute;cial" />'
				.'</form>';
		}

		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="facturation" />'
			.'<input type="hidden" name="spage" value="factures" />'
			.'<input type="hidden" name="f" value="'.$f.'" />'
			.'<input type="hidden" name="a" value="order" />'
			.'<input type="submit" value="'.(($paiement == 0)?'Valider le devis':'Modifier les d&eacute;tails de livraison').'" />'
			.'</form>';

		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="facturation" />'
			.'<input type="hidden" name="spage" value="factures" />'
			.'<input type="hidden" name="f" value="'.$f.'" />'
			.'<input type="hidden" name="a" value="predit" />'
			.'<input type="submit" value="D&eacute;finir le pro-rata" />'
			.'</form>';

		if ($paiement == 1)
		{
			echo '<form method="get" action="">'
				.'<input type="hidden" name="page" value="facturation" />'
				.'<input type="hidden" name="spage" value="factures" />'
				.'<input type="hidden" name="f" value="'.$f.'" />'
				.'<input type="hidden" name="a" value="pay" />'
				.'<input type="submit" value="Valider le paiement" />';

			// Sélection méthode de paiement
			echo '<select name="m">';
			foreach ($devis_methodes as $methode => $nom_methode)
				echo '<option value="'.$methode.'">'.htmlentities($nom_methode).'</option>';
			echo '</select></form>';
		}
	}
	else if ($s == 0 && mysql_num_rows($r) > 0) // Si il n'y a aucun abonnement associé, on propose d'en créer un
	{
		// On ne peut pas créer d'abonnement s'il n'y a pas d'élément mensuel (ligne tel) dans la facture, mais le bouton apparaitra quand même...
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="abonnements" />'
			.'<input type="hidden" name="spage" value="addabonnement" />'
			.'<input type="hidden" name="f" value="'.$f.'" />'
			.'<input type="hidden" name="a" value="create" />'
			.'<input type="submit" value="Cr&eacute;er un abonnement" />'
			.'</form>';
	}

	// Permet de voir l'abonnement associé s'il y en a un
	if ($s > 0)
	{
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="abonnements" />'
			.'<input type="hidden" name="s" value="'.$s.'" />'
			.'<input type="hidden" name="a" value="details" />'
			.'<input type="submit" value="Voir l\'abonnement associ&eacute;" />'
			.'</form>';
	}

	// On peut ajouter des comptes si la facture est validée
	if ($paiement >= 1)
	{
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="comptes" />'
			.'<input type="hidden" name="f" value="'.$f.'" />'
				.'<input type="hidden" name="lidc" value="'.$c.'" />'
			.'<input type="hidden" name="a" value="new" />'
			.'<input type="submit" value="Ajouter des comptes" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="comptes" />'
			.'<input type="hidden" name="f" value="'.$f.'" />'
			.'<input type="hidden" name="a" value="list" />'
			.'<input type="submit" value="Voir les comptes associ&eacute;s" />'
			.'</form>';
	}

	echo '<form method="get" action="">'
		.'<input type="hidden" name="page" value="facturation" />'
		.'<input type="hidden" name="spage" value="factures" />'
		.'<input type="hidden" name="f" value="'.$f.'" />'
		.'<input type="hidden" name="a" value="del" />'
		.'<input type="submit" value="Supprimer" />'
		.'</form>';

	echo '</td>'
		.'</tr></tfoot><tbody>';

	while ($row = mysql_fetch_row($r))
	{
		$id = (int)$row[0];
		$ref = $row[1];
		$quantite = (int)$row[2];
		$prixtotal = (float)$row[3];
		$prixunit = $prixtotal / $quantite;
		$type = (int)$row[4];

		echo '<tr>';
		echo '<td class="id">'.$id.'</td>';
		echo '<td class="ref">'.$ref.'</td>';
		echo '<td class="count">'.$quantite.'</td>';
		echo '<td class="price">'.round($prixunit, 2).' €</td>';
		echo '<td class="price">'.round($prixtotal, 2).' €</td>';
		if ($type == 0)
			echo '<td class="total price">'.round($prixtotal * $pr, 2).' €</td>';
		else
			echo '<td class="total price">'.round($prixtotal, 2).' €</td>';
		echo '<td class="action">';
		if ($paiement <= 1)
		{
			echo '<form method="get" action="">';
			echo '<input type="hidden" name="page" value="facturation" />';
			echo '<input type="hidden" name="spage" value="factures" />';
			echo '<input type="hidden" name="a" value="edit" />';
			echo '<input type="hidden" name="f" value="'.$f.'" />';
			echo '<input type="hidden" name="e" value="'.$id.'" />';
			echo '<input type="submit" value="Modifier" />';
			echo '</form>';
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

?>