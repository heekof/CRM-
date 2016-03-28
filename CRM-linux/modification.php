<?php

$niveau_prec=$p-1;
$mareference=substr($test1, 0, -3);
//echo '<br> La je dois modifier ! avec la reference = '.$mareference.' et un mavar3='.$mavar3.' <br>';
/*
$queryx = " SELECT  * ";
$queryx .= "FROM  argument  ";
$queryx .= "WHERE    numcli='$centrex' and reference='$mareference' ";


$mysql_resultx = mysql_query($queryx) or die ("Erreur : ".mysql_error());
while($rowx = mysql_fetch_array($mysql_resultx))
{

     ($rowx["commentaire"])=$mavar3;
	
}
*/
if($Vcommentairey==NULL){
$queryx ="UPDATE argument SET commentaire='$mavar3' WHERE reference='$mareference' "; 
$resultx = mysql_query($queryx);
}




?>