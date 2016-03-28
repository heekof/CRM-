<?php
$connect=mysql_connect("localhost","root","");
$db = mysql_select_db("etikeodb");

function cel($cel)
{
$cel=str_replace ("10","K",$cel);
$cel=str_replace ("11","L",$cel);
$cel=str_replace ("12","M",$cel);
$cel=str_replace ("1","B",$cel);
$cel=str_replace ("2","C",$cel);
$cel=str_replace ("3","D",$cel);
$cel=str_replace ("4","E",$cel);
$cel=str_replace ("5","F",$cel);
$cel=str_replace ("6","G",$cel);
$cel=str_replace ("7","H",$cel);
$cel=str_replace ("8","I",$cel);
$cel=str_replace ("9","J",$cel);


//... et ainsi de suite pour tout les jours et mois
return ($cel);
}
$col=0;
$lig=2;

$sql = "SELECT COUNT(NUMCLI) AS NBP FROM clienttab";    //****EDIT HERE**** you need to edit... WHERE `active` = 1 ORDER BY `date` DESC
$result = mysql_query($sql);
$colonne = mysql_fetch_array($result);
$nb = $colonne['NBP'];

$query = " SELECT * FROM clienttab ORDER BY RAISONSOCIALE";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());

while($row = mysql_fetch_array($mysql_result))
                              {
                                      $numcli = ($row["NUMCLI"]);
									  $raison = ($row["RAISONSOCIALE"]);
									  $agence = ($row["AGENCELIV"]);
									  $statutcli = ($row["STATUT"]);
									 if($statutcli =="franchise"){$raisons=$raison." agence ".$agence;}else{$raisons=$raison;}
for($i=1;$i<13;$i++)									  
	{
	
$tableauNombreVentes = array();
$yearac=date("Y");
$sql = " SELECT SUM(TOTAL_PAYE) AS NBR_VENTES FROM commandes WHERE YEAR(date_com)='".$yearac."' AND MONTH (date_com)='".$i."' AND NUMCLI='".$numcli."'";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
// Alimentation des tableaux de données
$tableauNombreVentes[$i] = $row['NBR_VENTES'];

}
echo cel($i).$lig,number_format($tableauNombreVentes[$i],2,".","").'€<br>';

	}}
?>