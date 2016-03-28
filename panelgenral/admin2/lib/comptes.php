<?php /* comptes.php */
/* Fonctions de gestion de comptes */

require_once('lib/random.php');

// $client: id client
function compte_creer($client)
{
}

// $client: id client
function nbComptes($client)
{
	$r = mysql_query("select count(*) from compte where idclient='".$client."'");
	$nb = mysql_fetch_row($r);
	return $nb[0];
}


?>