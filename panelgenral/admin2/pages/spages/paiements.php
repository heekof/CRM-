<?php /* paiements.php */
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

$title = 'Liste des factures pay�es';

$where = 'WHERE f.paiement = \'2\' ';

// G�re le filtrage par client (requete et url de la page)
if (isset($c))
{
	$where .= 'AND f.idclient = \''.$c.'\' ';
	$base_url = '&c='.$c;
}
else
	$base_url = '';

// Obtient une liste des dates (mois, ann�e) de factures
$r = mysql_query('SELECT DISTINCT MONTH(f.date_paiement), YEAR(f.date_paiement) FROM facture AS f '.$where.'ORDER BY date DESC;');

// Prend le mois en cours pour affichage si aucun n'�tait demand�
if (!isset($d))
{
	$d = getdate();
	
	$month = (int)$d['mon'];
	$year = (int)$d['year'];	
}

// Rajoute � pr�sent la partie date � la requete WHERE et � l'url de base pour les pages
$where .= 'AND MONTH(f.date_paiement) = '.$month.' AND YEAR(f.date_paiement) = '.$year.' ';
$base_url .= '&d='.$month.'%2F'.$year;

$navbar = '<div class="navbar">'
	.'<div class="action">'
	.'<form method="get" action="">'
	.'<input type="hidden" name="page" value="facturation" />'
	.'<input type="hidden" name="spage" value="paiements" />'
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
		.'<input type="hidden" name="spage" value="paiements" />';
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

// G�n�re la requ�te � �x�cuter

$facture_query = 'SELECT f.id, f.idclient, '
	.'c.nom, c.prenom, '
	.'DATE_FORMAT(f.date_paiement, \'%d/%m/%Y\'), '
	.'f.paiement, f.methode, '
	.'f.frais + SUM(ef.prix * ef.prorata), f.tva, f.prorata '
	.'FROM identite AS c, facture AS f LEFT JOIN elementfacture AS ef ON ef.idfacture = f.id '
	.$where.'AND c.numero = f.idclient '
	.'GROUP BY f.id ORDER BY f.idclient ASC, f.id DESC;';

if ($r = mysql_query($facture_query))
{
	echo $navbar;
	
	echo '<table class="list"><thead><tr>'
		.'<td>Id</td><td colspan="2">Client</td><td>Paiement</td><td>Prix HT</td><td>Prix TTC</td><td>Moyen</td><td>Action</td>'
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
		$date = $row[4];
		$paiement = (int)$row[5];
		$methode = (int)$row[6];
		$prix = (float)$row[7];
		$tva = (float)$row[8];
		$pr = (float)$row[9];
		
		$total_ht += $prix; 
		$total_ttc += $prix * (1 + $tva);
		
		$table_contents .= '<tr class="active">'
			.'<td class="id">'.$id.'</td>'
			.'<td class="id">'.$idc.'</td>'
			.'<td class="name"><a href="?page=clients&amp;a=details&amp;c='.$idc.'">'.htmlentities($nom).' '.htmlentities($prenom).'</a></td>'
			.'<td class="date">'.$date.'</td>'
			.'<td class="price">'.round($prix, 2).' �</td>'
			.'<td class="total price">'.round($prix * (1 + $tva), 2).' �</td>'
			.'<td class="info">'
			.htmlentities($devis_methodes[$methode])
			.'</td>'
			.'<td class="action">'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="factures" />'
			.'<input type="hidden" name="f" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="details" />'
			.'<input type="submit" value="D&eacute;tails" />'
			.'</form>'
			.'</td></tr>';
	}
	echo '<tfoot class="recap"><tr><td colspan="4">Total: </td><td class="price">'.round($total_ht, 2).' �</td><td class="total price">'.round($total_ttc, 2).' �</td><td colspan="2"></td></tfoot>';
	echo '<tbody>'
		.$table_contents
		.'</tbody>'
		.'</table>';
	
	echo $navbar;
}
else
	echo '<p class="error">Erreur lors de la requ�te MySQL.</p>';
	
?>