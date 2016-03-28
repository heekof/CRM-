<?php
require("haut.php");
//require("base.php");
// print("<br> <br> $labase <br> <br> ");


$base_ligne  =  explode("\n",$labase );

$nbe_ligne = count($base_ligne);

/*
print(" nbe_compte $nbe_compte <br> <br>");

print("base_ligne  $base_ligne[0] <br>");
print("base_ligne  $base_ligne[1] <br>");
print("base_ligne  $base_ligne[2] <br>");
print("base_ligne  $base_ligne[3] <br>");
print("base_ligne  $base_ligne[4] <br>");
*/

// print(" <br> separation $separation  <br> <br>");

for($a=0;$a < $nbe_ligne ; $a++)
{

$la_ligne = $base_ligne[$a];
$le_mot = explode($separation,$la_ligne);

$email = $le_mot[0];
$prenom = $le_mot[1];
$nom = $le_mot[2];
// $telephone2 = $le_mot[3];
// $nombase = $le_mot[4];

// $mot5 = $le_mot[5];

// print(" <br> Insertion : $mot0 - $mot1 - $mot2 - $mot3 - $mot4 - $mot5 nominsertion $nominsertion");


$query = "INSERT INTO baseclient (email,prenom,nom,nombase)";
$query  .= "VALUES ('$email','$prenom','$nom','$nominsertion')";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());



}


?>
<br> <br> <br> <br>
<center> <b> Enregistrement avec succés  !! </b> </center>