<?php
if($lolo!=1)
{
$queryy = " SELECT  commentaire ";
$queryy .= "FROM  argument  ";
$queryy .= "WHERE    numcli='$centrex' and commentaire='$mavar3' ";


$mysql_resulty = mysql_query($queryy) or die ("Erreur : ".mysql_error());
while($rowy = mysql_fetch_array($mysql_resulty))
{

    $Vcommentairey = ($rowy["commentaire"]);
	
}
}

 
else {
// code a mettre pour le retour !
echo '<br> mavar3='.$mavar3.' et reference ='.$test1.'<br>';


$queryy = " SELECT  commentaire ";
$queryy .= "FROM  argument  ";
$queryy .= "WHERE    numcli='$centrex' and commentaire='$mavar3'  ";



$mysql_resulty = mysql_query($queryy) or die ("Erreur : ".mysql_error());
while($rowy = mysql_fetch_array($mysql_resulty))
{

    $Vcommentairey = ($rowy["commentaire"]);
	
}
if( $Vcommentairey!=NULL) echo '<br> $Vcommentairey =='.$Vcommentairey;
else  echo '<br> $Vcommentairey == NULL';


} 


// si commentaire == NULL le commentaire n hexiste pas 




?>