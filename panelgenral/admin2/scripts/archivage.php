<?php
require_once('../lib/date.php');
/*require_once('../config.php');
require_once('../lib/mysql.php');*/
if (!isset($mysql_link))
{
	$mysql_link = mysql_connect("localhost" ,"root","");
	mysql_select_db("ktcentrex", $mysql_link);
}
$date10passe = date('y-m-d', date_ilya_njours(10, getdate(),0));

$incre = "0";
$query = " SELECT  * ";
$query .= " FROM cdr ";
$query .= " WHERE calldate <= '$date10passe' AND etatprix = 'yes' ORDER BY calldate desc LIMIT 0, 1000 ;";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());

$toutArchive = 1;//pour savoir si toutes les lignes ont été archivées

if($mysql_result)
{
	while($row = mysql_fetch_array($mysql_result,MYSQL_ASSOC))
	{
		$query = "INSERT INTO cdr2 (";
		$value = " VALUES (";
		foreach($row as $nomcol=>$valcol)
		{
			if($nomcol=="numero") continue;//on ne prend pas la clé auto_inc
			$query  .= $nomcol.",";
			$value 	.= "'$valcol',";
		}
		//retire les dernière virgules qui apparaissent
		$l1 = strlen($query) - 1;
		$l2 = strlen($value) - 1;
		$query  = substr($query,0,$l1);
		$value 	= substr($value,0,$l2);
		//complete les chaine
		$query  .= ") ";
		$value 	.= ")";
		
		$queryFinal = $query.$value;
		$result = @mysql_query($queryFinal) or die ("Erreur : ".mysql_error());
		if(!$result) $toutArchive *= 0;
		
		//suppression de la ligne sur cdr
		$result = @mysql_query("DELETE FROM cdr WHERE numero='".$row['numero']."'") or die ("Erreur : ".mysql_error());				
	}
	if($toutArchive)
		echo "<h2 align='center'>Mise &agrave; jour avec succ&egrave;s!</h2>";
	else echo "<h2 align='center'>Certaines lignes n'ont pas &eacute;t&eacute; archiv&eacute;es, voir toutes!</h2>";
	
}else{
	echo "<h2 align='center'>Problème lors de l'acc&egrave;s &agrave; la base de donn&eacute;es!</h2>";
}
?>