<?php /* devis.php */
/* Fonctions de gestion de devis */

$devis_tva_fr = 0.196;

$devis_paiements = array( 0 => 'Non payé', 1 => 'En attente de paiement', 2 => 'Payé');
$devis_methodes = array( 0 => 'Virement', 1 => 'Chèque', 2 => 'Carte bleue', 3 => 'Autre moyen' );

/*// $d: id devis
function devis_tva($d)
{
	global $devis_tva_fr;
	
	// Obtient des informations sur le client pour déterminer la TVA
	if (($r = mysql_query('SELECT c.pays, c.liv_pays FROM identite AS c, facture AS f WHERE c.numero = f.idclient AND f.id=\''.(int)$d.'\';'))
		&& ($row = mysql_fetch_row($r)))
	{
		$pays = trim($row[0]);
		$liv_pays = trim($row[1]);
		
		if ((strlen($liv_pays) > 0 && strcasecmp($liv_pays, 'france') == 0)
			|| (strlen($pays) > 0 && strcasecmp($liv_pays, 'france') == 0))
			return $devis_tva_fr;
		else // Pas de TVA hors france
			return 0;
	}
	else // Par défaut, on fait payer la TVA
		return $devis_tva_fr;
}*/

// $d: id devis
// $m: méthode de paiement (cf liste $devis_methodes)
//  0: virement
//  1: cheque
//  2: carte bleue
//  3: autre
function devis_valider($d, $adresse, $codepostal, $ville, $pays, $m=3)
{
	global $devis_tva_fr;
	
	// On met la TVA française si le pays est 'france' ou qu'il n'est pas indiqué...
	if (strlen($pays) <= 0 || strcasecmp(trim($pays), 'france') == 0)
		$tva = $devis_tva_fr;
	else // Dans le cas contraire on accorde le bénéfice du doute...
		$tva = 0;
	
	return (bool)mysql_query('UPDATE facture '
		.'SET paiement = \'1\', methode = \''.$m.'\''
		.', liv_adresse = \''.$adresse.'\' '
		.', liv_codepostal = \''.$codepostal.'\' '
		.', liv_ville = \''.$ville.'\' '
		.', liv_pays = \''.$pays.'\' '
		.', tva = \''.$tva.'\' '
		.'WHERE id = \''.(int)$d.'\' AND paiement <= 1;');
}

// $f: id facture
// $m: méthode de paiement (cf liste $devis_methodes)
//  0: virement
//  1: cheque
//  2: carte bleue
//  3: autre
function devis_valider_paiement($f, $m=3)
{
	$m = (int)$m;
	
	if ($m < 0 || $m > 3)
		$m = 3;

	//return (bool)mysql_query('UPDATE facture SET paiement = \'2\', methode = \''.$m.'\', date_paiement = NOW() WHERE id = \''.(int)$f.'\' AND paiement = 1;');
	
	/* Met à jour la facture */
	$r = (bool)mysql_query('UPDATE facture AS f '
		.'LEFT JOIN abonnement AS a '
		.'ON a.id = f.idabonnement '
		.'SET f.paiement = \'2\', f.methode = \''.$m.'\', f.date_paiement = NOW(), a.etat = \'on\' '
		.'WHERE f.id = \''.(int)$f.'\' AND f.paiement = \'1\';');
	
	/* Envoie un mail si la requête a été fructueuse */
	if (mysql_affected_rows() > 0)
		mysql_query('INSERT INTO mail (idenCli, idfacture, etat, nomsg) '
			.'SELECT f.idclient, f.id, \'no\', \'paiementok\' '
			.'FROM facture AS f '
			.'WHERE f.id = \''.$f.'\';');
		
	return $r;
}

// $f: id facture ( > 0 )
// $e: id element ( > 0 )
// $q: quantite ( >= 0 )
// $p: prix total ( >= 0 )
function devis_modifier_element($f, $e, $q, $p)
{
	$f = (int)$f;
	$e = (int)$e;
	$q = (int)$q;
	$p = (float)$p;
	
	if ($q < 0)
		$q = 0;
	if ($p < 0)
		$p = 0;
	
	return (bool)mysql_query('UPDATE elementfacture SET quantite = \''.$q.'\', prix = \''.$p.'\' WHERE idfacture = \''.$f.'\' AND idelement = \''.$e.'\';');
}

?>