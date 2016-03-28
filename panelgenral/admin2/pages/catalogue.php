<?php /* catalogue.php */
require_once('lib/check.php');
require_once('lib/form.php');
require_once('lib/element.php');
require_once('lib/paging.php');

function generate_item_form($editable, $update)
{
	// Variables globales utilisées pour (pré)remplir le formulaire
	global $id, $type, $ref, $prix, $nom, $description, $image, $actif;
	// Variables de configuration
	global $images_base, $max_image_size, $element_types;
	
	echo '<form enctype="multipart/form-data" method="post" action="?page=catalogue&amp;e='.$id.'&amp;a=';
	if ($editable)
	{
		if ($update)
			echo 'update';
		else
			echo 'add';
	}
	else
		echo 'edit';
	echo '">';
	echo '<table class="form">';
	echo '<thead><tr><td colspan="2">';
	if (!$editable || $update)
		echo 'Element n°'.$id;
	else
		echo 'Nouvel &eacute;l&eacute;ment';
	echo '</td></tr></thead>';
	echo '<tfoot><tr><td colspan="2"><input type="submit" value="';
	if ($editable)
	{
		if ($update)
			echo 'Modifier';
		else
			echo 'Créer';
	}
	else
		echo 'Editer';
	echo '" /></td></tr></tfoot>';
	echo '<tbody>';
	insert_form_element('Type', 'select', 'type', $type, $editable, $element_types);
	insert_form_element('Référence', 'text', 'ref', $ref, $editable);
	insert_form_element('Nom', 'text', 'nom', $nom, $editable);
	insert_form_element('Description', 'textarea', 'description', $description, $editable);
	insert_form_element('Prix', 'text', 'prix', $prix, $editable);
	if (strlen($image) > 0)
		insert_form_element('Image', 'imgupload', 'image', $image, $editable, $max_image_size, $images_base.$image);
	else
		insert_form_element('Image', 'imgupload', 'image', $image, $editable, $max_image_size);
	echo '</tbody></table>';
	echo '</form>';
}

// Initialisation des variables
$id = 0;
$type = '';
$ref = '';
$prix = '';
$nom = '';
$description = '';
$image = '';
$actif = 0;

// Id Element
if (isset($_GET['e']))
	$e = (int)$_GET['e'];
else if (isset($e))
	unset($e);

// Type Element
if (isset($_GET['t']))
	$t = (int)$_GET['t'];
else if (isset($t))
	unset($t);

// Action
if (isset($_GET['a']))
	$a = strtolower($_GET['a']);
else
	$a = 'list';

if ($a != 'list' && $a != 'details' && $a != 'edit' && $a != 'update' && $a != 'new' && $a != 'add' && $a != 'toggle')
	$a = 'list';

if ($a == 'edit')
	$editable = true;
else
	$editable = false;

if ($a == 'toggle')
{
	if (isset($e))
	{
		mysql_query('UPDATE element SET actif = NOT actif WHERE id = \''.$e.'\';');
		$a = 'list';
		unset($e);
	}
}
else if ($a == 'update' || $a == 'add')
{
	$type = (int)$_POST['type'];
	$ref = trim($_POST['ref']);
	$prix = (float)$_POST['prix'];
	$nom = trim($_POST['nom']);
	$description = trim($_POST['description']);
	$actif = 1;
	$image = false;
	
	$errors = array();
	
	if ($type < 0 || $type > 2) /*DE JEAN ETIENNE  :  j ai changé  if ($type < 0 || $type > 1) en if ($type < 0 || $type > 2) pour que tous les trois types soient pris en compte*/
		$errors[] = 'Type incorrect ou manquant';
	if (strlen($ref) <= 0)
		$errors[] = 'Référence incorrecte ou manquante';
	if ($prix < 0)
		$errors[] = 'Prix incorrect';
	if (strlen($nom) <= 0)
		$errors[] = 'Nom incorrect ou manquante';
	if (strlen($description) <= 0)
		$errors[] = 'Description incorrecte ou manquante';
	if ($a == 'update' && !isset($e))
		$errors[] = 'Numéro d\'élément non spécifié';
	if (!check_upload('image', $max_image_size))
		$errors[] = 'Image invalide';
	else if (isset($_FILES['image']) && $_FILES['image']['size'] > 0)
		$image = true;
	
	if (count($errors) <= 0) // Pas d'erreur
	{
		if ($a == 'update') // Soit modification
		{
			if (!mysql_query('UPDATE element SET '
				.'type = "'.$type.'" '
				.', ref = "'.$ref.'" '
				.', prix = \''.$prix.'\' '
				.', nom = "'.$nom.'" '
				.', description = "'.$description.'" '
				.' WHERE id = \''.$e.'\';'))
				$errors[] = 'Erreur lors de la requête MySQL';
		}
		else // Soit insertion
		{
			if (mysql_query('INSERT INTO element (type, ref, prix, nom, description) '
				.'VALUES("'.$type.'" '
				.', "'.$ref.'" '
				.', \''.$prix.'\' '
				.', "'.$nom.'" '
				.', "'.$description.'");'))
			{
				$e = mysql_insert_id(); // Prend le nouvel id client à afficher
				$a = 'details';
			}
			else
				$errors[] = 'Erreur lors de la requête MySQL';
		}
	}
	
	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		if ($a == 'edit')
			$a = 'reedit';
	}
	else if ($image) // Si la requête a réussi, on peut s'occuper de l'image
	{
		$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		$newname = 'upload/element-'.(int)$e.'.'.$ext;
		move_uploaded_file($_FILES['image']['tmp_name'], $upload_root.$newname);
		mysql_query("UPDATE element SET image=\"$newname\" WHERE id='$e';"); // Met à jour la BDD comme il se doit
	}
}

// Choisit un titre à la page en fonction de l'affichage
if ($a == 'list')
	$title = 'Liste des éléments';
else if ($a == 'new')
	$title = 'Ajout d\'un nouvel élément';
else
{
	if ($a == 'edit' || $a == 'reedit')
		$title = 'Edition ';
	else
		$title = 'Détails ';
	
	if (isset($e))
		$title .= 'de l\'élément n°'.$e;
	else
		$title .= 'des éléments';
}

if ($a == 'reedit')
{
	$id = $e;
	generate_item_form(true, true);
}
else if ($a == 'new')
	generate_item_form(true, false);
else
{
	// Gère le filtrage par élément ou par type
	if (isset($e))
	{
		$where = 'WHERE id = \''.$e.'\' ';
		$base_url = '&e='.$e;
	}
	else if (isset($t))
	{
		$where = 'WHERE type = \''.$t.'\' ';
		$base_url = '&t='.$t;
	}
	else
	{
		$where = '';
		$base_url = '';
	}
	
	if ($a == 'list' || !isset($e))
	{
		$r = mysql_query('SELECT COUNT(*) FROM element '.$where.';');
		if ($row = mysql_fetch_row($r))
			$page_count = page_count($row[0]);
		else
			$page_count = 1;
		$page = page_get($page_count);
		$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;
		
		$navbar = '<div class="navbar">'
			.'<div class="action">'
			.'Voir: '
			.'<a href="?page=catalogue&amp;a=list">Tout le catalogue</a> ';
		foreach ($element_types as $item_type => $type_name)
			$navbar .= '<a href="?page=catalogue&amp;a=list&amp;t='.$item_type.'">'.$type_name.'</a> ';
		$navbar .= '</div>'
			.'<div class="action"><a href="?page=catalogue&amp;a=new">Ajouter un nouvel &eacute;l&eacute;ment</a></div>'
			.'<div class="action">'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="catalogue" />'
			.'<input type="hidden" name="a" value="details" />'
			.'Voir l\'&eacute;l&eacute;ment: '
			.'<input type="text" size="4" name="e" value="'.(isset($e)?$e:'').'" />'
			.'<input type="submit" value="Ok" />'
			.'</form>'
			.'</div>'
			.'<div class="pages">Page: '.page_build_menu('?page=catalogue'.$base_url.'&p=', $page, $page_count).'</div>'
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
	
	$item_query = 'SELECT id, type, ref, prix, nom, description, image, actif '
		.'FROM element '
		.$where
		.'ORDER BY id';
	
	if ($paging)
		$item_query .= ' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE;
	
	$item_query .= ';';

	if ($r = mysql_query($item_query))
	{
		echo $navbar;
		
		if ($a == 'list')
			echo '<table class="list"><thead><tr>'
				.'<td>Id</td><td>Type</td><td>R&eacute;f&eacute;rence</td><td>Prix</td><td>Actif</td><td>Action</td>'
				.'</tr></thead><tbody>';
		while ($row = mysql_fetch_row($r))
		{
			$id = (int)$row[0];
			$type = (int)$row[1];
			$ref = $row[2];
			$prix = (float)$row[3];
			$nom = $row[4];
			$description = $row[5];
			$image = $row[6];
			$actif = (int)$row[7];
			if ($a == 'list')
			{
				if ($actif)
					echo '<tr class="active">';
				else
					echo '<tr class="inactive">';
				echo '<td class="id">'.$id.'</td>';
				echo '<td>'.$element_types[$type].'</td>';
				echo '<td>'.htmlentities($ref).'</td>';
				echo '<td class="price">'.$prix.'</td>';
				echo '<td class="info">'.($actif?'Oui':'Non').'</td>';
				echo '<td class="action">';
				echo '<form method="get" action="">'
					.'<input type="hidden" name="page" value="catalogue" />'
					.'<input type="hidden" name="e" value="'.$id.'" />'
					.'<input type="hidden" name="a" value="details" />'
					.'<input type="submit" value="D&eacute;tails" />'
					.'</form>';
				echo '<form method="get" action="">'
					.'<input type="hidden" name="page" value="catalogue" />'
					.'<input type="hidden" name="e" value="'.$id.'" />'
					.'<input type="hidden" name="a" value="toggle" />'
					.'<input type="submit" class="toggle" value="'.($actif?'D&eacute;sactiver':'Activer').'" />'
					.'</form>';
				echo '</td></tr>';
			}
			else
				generate_item_form($editable, true);
		}
		if ($a == 'list')
			echo '</tbody></table>';
		
		echo $navbar;
	}
	else
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
}
?>