<?php
require_once('../config.php');
require_once('../lib/mysql.php');

mysql_auto_connect();
	$today = date('Y-m-d H:i:s',time());//Date du jour
	//ensemble des credits
	$query = " SELECT  * ";
	$query .= " FROM credit ";
	echo $today ;
	$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
	
	if($mysql_result)
	{
		while($row = mysql_fetch_array($mysql_result,MYSQL_ASSOC))
		{
			$query = "INSERT INTO historique_credit (datearchive,idcredit,";
				$value = " VALUES ('".$today."','".$row['numero']."',";
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
			
			
		}//Fin mise archivage
	}
	
mysql_auto_close();
?>