<?php /* devis.php */

// $s: id abonnement ( > 0 )
// $e: id element ( > 0 )
// $q: quantite ( >= 0 )
// $p: prix total ( >= 0 )
function abonnement_modifier_element($s, $e, $q, $p)
{
	$s = (int)$s;
	$e = (int)$e;
	$q = (int)$q;
	$p = (float)$p;
	
	if ($q < 0)
		$q = 0;
	if ($p < 0)
		$p = 0;
	
	return (bool)mysql_query('UPDATE elementabonnement SET quantite = \''.$q.'\', prix = \''.$p.'\' WHERE idabonnement = \''.$s.'\' AND idelement = \''.$e.'\';');
}

// $s: id abonnement ( > 0 )
function abonnement_changer_etat($s)
{
	$s = (int)$s;
	
	mysql_query('UPDATE abonnementclients SET etat = (etat % 2) + 1 WHERE numero = \''.$s.'\';');
}

?>