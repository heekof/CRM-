<?php /* paging.php */

// Fonctions génériques de navigation par pages
// La numérotation commence à 1

// Définit la taille par défaut d'une page
define('DEFAULT_PAGE_SIZE', 20);

// Compte le nombre de pages nécéssaire
// $element_count: Nombre d'éléments total
// $page_size: Taille d'une page
function page_count($element_count, $page_size = DEFAULT_PAGE_SIZE)
{
	$page_size = (int)$page_size;
	$element_count = (int)$element_count;
	
	if ($page_size <= 0)
		$page_size = 1;
	
	if ($element_count < 0)
		$element_count = 0;
	
	// Calcule le nombre de page entières nécéssaire pour afficher les éléments
	$page_count = (int)($element_count / $page_size);
	// Donne une page (partielle) de plus sauf si on a un nombre d'élements multiple de la taille d'une page (auquel cas on ajouterait une page vide à la fin)
	if ($element_count == 0 || $element_count % $page_size != 0)
		$page_count++;
	
	return $page_count;
}

// Obtient la page demandée par l'utilisateur
// Cette fonction regarde la variable $_GET['p']
// Pour utiliser une autre source comme nombre de pages, il ne faut pas utiliser cette fonction
// $page_count: Nombre de pages total (calculé précedemment avec page_count() par exemple) ou false si non spécifié
function page_get($page_count = false)
{
	$page_count = (int)$page_count;
	
	if ($page_count < 1)
		$page_count = 1;
		
	if (isset($_GET['p']))
		return page_check($_GET['p'], $page_count);
	else
		return 1;
}

// Vérifie que le numéro de page est bien compris dans la bonne plage, et retourne le nouveau numéro
// $page: Numéro de la page demandée
// $page_count: Nombre de pages total (calculé précedemment avec page_count() par exemple) ou false si non spécifié
function page_check($page, $page_count = false)
{
	$page = (int)$page;
	
	if ($page <= 0)
		$page = 1;
	else if ($page_count && $page > $page_count)
		$page = $page_count;
	
	return $page;
}

// Construit le menu de pages comme une succession de liens
// $base_url: URL de base à mettre dans le lien (exemple: 'page.php?p=') à laquelle la fonction ajoutera le numéro de page
// $page: Numéro de la page demandée
// $page_count: Nombre total de pages
// $max_count: Nombre maximum de pages à afficher dans le menu / false pour tout afficher
// $first: Texte pour le lien "Début" / false pour masquer le lien
// $last: Texte pour le lien "Fin" / false pour masquer le lien
// $prev: Texte pour le lien "Précédent" / false pour masquer le lien
// $next: Texte pour le lien "Suivant" / false pour masquer le lien
function page_build_menu($base_url, $page, $page_count, $max_count = 10, $first = '<<', $last = '>>', $prev = '<', $next = '>')
{
	$base_url = htmlentities($base_url);
	$page = page_check($page, $page_count);
	
	if ($max_count && $page_count > $max_count)
	{
		$max_count = (int)$max_count;
		$half = (int)($max_count / 2);
		
		if ($page > $half)
			$start = $page - $half;
		else
			$start = 1;
		
		$end = $start + $max_count - 1;
		
		if ($end > $page_count)
		{
			$end = $page_count;
			$start = $end - $max_count + 1;
		}
		
		$max_count = true;
	}
	else
	{
		$start = 1;
		$end = $page_count;
		$max_count = false;
	}
	
	// Construction du menu
	$menu = '';
	if ($page_count > 2 && $first) // On affiche << et >> si il y a plus de deux pages
		$menu .= '<a href="'.$base_url.'1">'.htmlentities($first).'</a> ';
	if ($page > 1 && $prev) // Affiche le retour à la page précédente pour toutes les pages sauf la première
		$menu .= '<a href="'.$base_url.($page - 1).'">'.htmlentities($prev).'</a> ';
	if ($start > 1)
		$menu .= '... ';
	for ($i = $start; $i <= $end; $i++)
		if ($i != $page)
			$menu .= '<a href="'.$base_url.$i.'">'.$i.'</a> ';
		else
			$menu .= $i.' ';
	if ($end < $page_count)
		$menu .= '... ';
	if ($page + 1 <= $page_count && $next) // Affiche le lien page suivante pour toutes les pages sauf la dernière
		$menu .= '<a href="'.$base_url.($page + 1).'">'.htmlentities($next).'</a> ';
	if ($page_count > 2 && $last) // On affiche << et >> si il y a plus de deux pages
		$menu .= '<a href="'.$base_url.($page_count).'">'.htmlentities($last).'</a> ';
	
	return $menu;
} ?>