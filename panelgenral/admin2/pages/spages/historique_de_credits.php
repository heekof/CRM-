<?php/*historique_de_credits.php*/
?>
<center><form action="?page=gestioncredits&spage=historique_de_credits" method="POST">
Choisir un client
<?php
	$q_info_client = "SELECT numero,nom, prenom FROM identite ;";
	$result_infos  = @mysql_query($q_info_client);
	
	echo '<select name="idclient" id="idclient">'
		.'<option value="aucun" selected="selected">-choisir un client-</option>';
		while($infos= @mysql_fetch_row($result_infos))
		{
			$num_client	   = $infos[0];
			$nom_client    = $infos[1];
			$prenom_client = $infos[2];
			echo '<option value="'.$num_client.'">'.$prenom_client.' '.$nom_client.'</option>';
		}
	echo '</select>';
?>&nbsp;&nbsp;&nbsp;
<input type="submit" value="Voir historique">
</form></center>
<?php

if(!isset($idclient) && !$idclient)
{
	 $idclient = $num_client;
}//Nom du client en cours
	$result_infos = @mysql_query("SELECT numero,nom, prenom FROM identite where numero='$idclient';");
	while($infos= @mysql_fetch_row($result_infos))
	{
			$num_client	   = $infos[0];
			$nom_client    = $infos[1];
			$prenom_client = $infos[2];
			echo '<center><h2>Historique de cr&eacute;dit du client : '.$nom_client.' '.$prenom_client.'</h2></center>';
	}
/**********************************/
require_once('lib/date.php');
require_once('lib/paging.php');
require_once('lib/number.php');
$title = 'Historique de credits ';

	$credit_query = " SELECT * FROM historique_credit2 WHERE idclient='$idclient' order by dateop desc ";
	$r_historique = mysql_query($credit_query) or die ("Erreur : ".mysql_error());
	
		if ($row = mysql_fetch_row($r_historique))
			$page_count = page_count($row[0]);
		else
			$page_count = 1;
		$page = page_get($page_count);
		$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;
		
	$navbar = '<div class="navbar">'
			.'<div class="pages">Page: '.page_build_menu('?page=gestioncredits&spage=historique_de_credits&idclient='.$idclient.'&p=', $page, $page_count).'</div>'
			.'</div>';
	
	
				
	$credit_query .= ' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE.';';
	
	if($r = mysql_query($credit_query))
	{
		echo $navbar;
		echo '<table class="list"><thead><tr>'
				."<td>Id</td><td>Date de l'op&eacute;ration</td><td>Op&eacute;ration</td><td>Montant de l'op&eacute;ration</td><td>Ancien cr&eacute;dit</td><td>Cr&eacute;dit apr&egrave;s</td>"
				.'</tr></thead><tbody>';
				
		while ($row = mysql_fetch_array($r))
		{
			$id = (int)$row['numero'];
			$idclient = $row['idclient'];
			$idcredit = $row['idcredit'];
			$date = $row['dateop'];
			$typeop = $row['typeoperation'];
			$mtOp = $row['montant'];
			$ancienMt = $row['ancienmontant'];
			$credit = $row['nouveaumontant'];
				$TdateHeure = explode(' ',$date);
				$tDate = explode('-',$TdateHeure[0]);
				
				echo '<tr class="active"><td class="id">'.$id.'</td>';
				echo '<td>'.$tDate[2].'/'.$tDate[1].'/'.$tDate[0].' &agrave; '.$TdateHeure[1].'</td>';
				echo '<td>'.$typeop.'</td>';
				echo '<td>'.$mtOp.' €</td>';
				echo '<td>'.$ancienMt.' €</td>';
				echo '<td>'.$credit.' €</td>';
				echo '</tr>';
		}
		echo '</tbody></table>';
		echo $navbar;
	}
	
?>