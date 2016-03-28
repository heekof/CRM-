<?php /* impayes.php */
require_once('lib/devis.php');
require_once('lib/paging.php');

// Id Client
if (isset($_GET['c']))
	$c = (int)$_GET['c'];
else if (isset($c))
	unset($c);

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

$title = 'Liste des factures impayées';

//
$where = 'WHERE f.paiement = \'1\' AND f.idabonnement IS NOT NULL ';

// Gère le filtrage par client (requete et url de la page)
if (isset($c))
{
	$where .= 'AND f.idclient = \''.$c.'\' ';
	$base_url = '&c='.$c;
}
else
	$base_url = '';

// Obtient une liste des dates (mois, année) de factures
$r = mysql_query('SELECT DISTINCT MONTH(f.date), YEAR(f.date) FROM facture AS f '.$where.'ORDER BY date DESC;');

// Prend le mois en cours pour affichage si aucun n'était demandé
if (!isset($d))
{
	$d = getdate();
	
	$month = (int)$d['mon'];
	$year = (int)$d['year'];	
}

// Rajoute à présent la partie date à la requete WHERE et à l'url de base pour les pages
$where .= 'AND MONTH(f.date) = '.$month.' AND YEAR(f.date) = '.$year.' ';
$base_url .= '&d='.$month.'%2F'.$year;

$navbar = '<div class="navbar">'
	.'<div class="action">'
	.'<form method="get" action="">'
	.'<input type="hidden" name="page" value="facturation" />'
	.'<input type="hidden" name="spage" value="impayes" />'
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
		.'<input type="hidden" name="spage" value="impayes" />';
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
$navbar .= '<hr />'
	.'</div>';

// Génère la requête à éxécuter

$facture_query = 'SELECT f.id, f.idclient, '
	.'c.nom, c.prenom, c.telephonef, c.telephonep, c.telephoneb, c.email, '
	.'DATE_FORMAT(f.date, \'%d/%m/%Y\'), '
	.'f.paiement, f.methode, '
	.'f.frais + SUM(ef.prix * ef.prorata), f.tva, f.prorata '
	.'FROM identite AS c, facture AS f LEFT JOIN elementfacture AS ef ON ef.idfacture = f.id '
	.$where.'AND c.numero = f.idclient '
	.'GROUP BY f.id ORDER BY f.idclient ASC, f.id DESC;';

if ($r = mysql_query($facture_query))
{
	echo $navbar;
	
	echo '<table class="list"><thead><tr>'
		.'<td>Id</td><td colspan="2">Client</td><td>T&eacute;l. fixe</td><td>T&eacute;l. portable</td><td>T&eacute;l. bureau</td><td>E-Mail</td><td>Emission</td><td>Prix HT</td><td>Prix TTC</td><td>Action</td>'
		.'</tr></thead>';
	
	$total_ht = 0;
	$total_ttc = 0;
	
	$table_contents = '';
	
	while ($row = mysql_fetch_row($r))
	{
		$id = (int)$row[0];
		$idc = (int)$row[1];
		$nom = trim($row[2]);
		$prenom = trim($row[3]);
		$telephonef = trim($row[4]);
		$telephonep = trim($row[5]);
		$telephoneb = trim($row[6]);
		$email = trim($row[7]);
		$date = $row[8];
		$paiement = (int)$row[9];
		$methode = (int)$row[10];
		$prix = (float)$row[11];
		$tva = (float)$row[12];
		$pr = (float)$row[13];
		
		$total_ht += $prix; 
		$total_ttc += $prix * (1 + $tva);
		
		$table_contents .= '<tr class="active">'
			.'<td class="id">'.$id.'</td>'
			.'<td class="id">'.$idc.'</td>'
			.'<td class="name"><a href="?page=clients&amp;a=details&amp;c='.$idc.'">'.htmlentities($nom).' '.htmlentities($prenom).'</a></td>'
			.'<td class="info">'.htmlentities($telephonef).'</td>'
			.'<td class="info">'.htmlentities($telephonep).'</td>'
			.'<td class="info">'.htmlentities($telephoneb).'</td>'
			.'<td class="info"><a href="mailto:'.htmlentities($email).'">'.htmlentities($email).'</a></td>'
			.'<td class="date">'.$date.'</td>'
			.'<td class="price">'.round($prix, 2).' €</td>'
			.'<td class="total price">'.round($prix * (1 + $tva), 2).' €</td>'
			.'<td class="action">'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="facturation" />'
			.'<input type="hidden" name="spage" value="factures" />'
			.'<input type="hidden" name="f" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="details" />'
			.'<input type="submit" value="D&eacute;tails" />'
			.'</form>'
			.'</td></tr>';
	}
	echo '<tfoot class="recap"><tr><td colspan="8">Total: </td><td class="price">'.round($total_ht, 2).' €</td><td class="total price">'.round($total_ttc, 2).' €</td><td colspan="1"></td></tfoot>';
	echo '<tbody>'
		.$table_contents
		.'</tbody>'
		.'</table>';
	
	echo $navbar;
}
else
	echo '<p class="error">Erreur lors de la requête MySQL.</p>';
	
?>