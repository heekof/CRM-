<?php
$mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");
mysql_select_db("testcentrex", $mysql_link);

$sql="TRUNCATE TABLE pubcorrespondance";
mysql_query($sql);


// ALIMENTER TABLE DE CORRESPONDANCE
$query = "SELECT COUNT(*) as num FROM identite";
$result=mysql_query($query);
$nbe_ligne = mysql_fetch_array($result);
$nbe_ligne= $nbe_ligne['num'];


// SI LE NOMBRE DE LIGNE EST INFERIEUR OU EGAL A 500
if($nbe_ligne <= 5){
if($nbe_ligne == 1){
$limit =1;
$start = 0;
$i=1;
include('pub.php');
//sleep(0.10);
}
else
{
for($i=1; $i<=$nbe_ligne ;$i++)
{
$limit =1;
$start = ($i - 1);
include('pub.php');
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
include('pub.php');
//sleep(0.10);
}
for($j=1; $j<=$reste;$j++)
{
$limitfin = 1;
$startfin = ($nb_tours * 5) + ($j - 1);
include('pubfin.php');
//sleep(0.10);
}

}

else{
for($i=1; $i<=5;$i++)
{
$limit = $nb_tours;
$start = ($i - 1) * $limit;
include('pub.php');
//sleep(0.10);
}


}
}


function weeksPerMonth($month, $year) {
  $day = mktime(1, 1, 1, $month, 1, $year);
  $nday = mktime(1, 1, 1, $month, date('t', $day), $year);
  $week = date('W', $day);
  $nweek = date('W', $nday);
  $lweek = date('W', mktime(1, 1, 1, 12, 28, $year));
  if ($nweek > $week) $res = $nweek - $week;
  else if ($lweek > $week) $res = $nweek + $lweek - $week;
  else $res = (int)$nweek;
  return $res + 1;
}
 
echo weeksPerMonth(3, 2007);
?>

