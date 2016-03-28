<?php
$mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");
mysql_select_db("testcentrex", $mysql_link);


// les adresses email
$req2 ="SELECT numero as num  FROM identite
  WHERE NOT EXISTS (SELECT numcli FROM pubcorrespondance WHERE pubcorrespondance.numcli = identite.numero )";
$sql2 = mysql_query($req2) or die ("Erreur : ".mysql_error());
while($rows = mysql_fetch_array($sql2))
                              {
							         $cl= ($rows["num"]);
									  
								  
$sql = 'INSERT INTO  intermediares(numcli) VALUES ("'.$cl.'")';
mysql_query($sql);						  
                                      
}

$query = "SELECT COUNT(*) as num FROM intermediares";
$result=mysql_query($query);
$nbe_ligne = mysql_fetch_array($result);
$nbe_ligne= $nbe_ligne['num'];


// SI LE NOMBRE DE LIGNE EST INFERIEUR OU EGAL A 500
// SI LE NOMBRE DE LIGNE EST INFERIEUR OU EGAL A 500
if($nbe_ligne <= 5){
if($nbe_ligne == 1){
$limit =1;
$start = 0;
$i=1;
include('insertionpub.php');
//sleep(0.10);
}
else
{
for($i=1; $i<=$nbe_ligne ;$i++)
{
$limit =1;
$start = ($i - 1);
include('insertionpub.php');
//sleep(0.10);
}
}
}
else{
// SI LE NOMBRE DE LIGNE EST SUPERIEUR  A 500
// LA DIVISION
$nb_tours=floor($nbe_ligne/5);
// LE RESTE DE LA DIVISION
$reste = ($nbe_ligne % 5);
// ECRITURE DES LIGNE SI LE RESTE EST SUPERIEUR A 0
if($reste > 0){

for($i=1; $i<=5;$i++)
{
$limit = $nb_tours;
$start = ($i - 1) * $limit;
include('insertionpub.php');
//sleep(0.10);
}
for($j=1; $j<=$reste;$j++)
{
$limitfin = 1;
$startfin = ($nb_tours * 5) + ($j - 1);
include('insertionpubfin.php');
//sleep(0.10);
}

}

else{
for($i=1; $i<=5;$i++)
{
$limit = $nb_tours;
$start = ($i - 1) * $limit;
include('insertionpub.php');
//sleep(0.10);
}


}
}

?>