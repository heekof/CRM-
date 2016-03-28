<?php
 

// setlocale (LC_TIME, 'fr_FR','fra'); 
setlocale (LC_TIME, 'fr_FR','fra'); 
// setlocale (LC_TIME, 'fr_FR');
// $ladate = date('h-i-s, j-m-y');

$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");

$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

$ladatefr = $jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y"); 
$heure=date("H:i:s");
$ladate = $ladatefr."-".$heure; 


$query = "INSERT INTO  support (etat,sujet,message,numclient,etatlectureclient,etatlectureadmin,produit,etat3,date)";
$query  .= "VALUES ('ouvert','$sujet','$data','$numclient1','no','no','$produit','$etat3','$ladate')";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());



$query1 = " SELECT  * ";
$query1 .= "FROM  identite  ";
$query1 .= "WHERE numero = '$numclient1' ";

$mysql_result = mysql_query($query1) or die ("Erreur : ".mysql_error());
$ligne = 0;
while($row = mysql_fetch_array($mysql_result))
{
    $email = ($row["email"]);
  

}



$message1 = "Bonjour Madame, Monsieur, \n "; 
$message5 = "\n \nNous venons de repondre a votre message.\n\n
Vous pouvez prendre connaissance de notre reponse sur cette adresse ::\n
http://www.kt-centrex.com/support.php \n
Nous vous remercions pour la confiance que vous accordez à kt-centrex et
restons à votre disposition.\n\n

Cordialement,
\n\n\n
Ceci est un mail automatique, vous ne pouvez pas y repondre
 ";

 
$message4 = "\n\n\n\n  Support de kt-centrex \n Cordialement"; 
$message7 = $message1.$message5 ; 
$entete = "From: \"Support KTcentrex.com\" <info\@kt-centrex.com> Reply-To:info\@kt-centrex.com Content-Type: text/html; charset=\"iso-8859-1\" Content-Transfer-Encoding: 8bit";

 

$query1 = "INSERT INTO mailstosend (email, objet, message,entete, etat,idsignature)";
$query1  .= "VALUES ('$email','Support kt-centrex : Une reponse vous attend','$message7','$entete','no','no')";
$result = mysql_query($query1) or die ("Erreur : ".mysql_error());


?>


