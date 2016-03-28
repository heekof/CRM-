<?php
require_once('lib/cryptage.php');
$mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");
mysql_select_db("testcentrex", $mysql_link);


function datePlus($dateDo,$nbrJours)
{
$timeStamp = strtotime($dateDo); 
$timeStamp += 24 * 60 * 60 * $nbrJours;
$newDate = date("Y-m-d", $timeStamp);
return  $newDate;
}

$datej=date("Y-m-d");



$objet="kt-centrex.com : Commande non terminée";


$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";
						
$headers ='From: "KTcentrex.com" <support@ktcentrex.com>'."\n";
$headers .='Reply-To: support@ktcentrex.com'."\n";
$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';



			
			
			
$query = " SELECT * FROM identite WHERE daterelance='".$datej."' AND nbrelance!='closed'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    //$nomgroupe = ($row["numgroup"]) ;
    $passw = ($row["password"]) ;
	$pseudo = ($row["nickhandle"]) ;
	$email = ($row["email"]) ;
    $numero = ($row["numero"]) ;
    $prenom = ($row["prenom"]) ;
	$nom = ($row["nom"]) ;
    $nbrelance = ($row["nbrelance"]) ;
	
	

$mpass = decrypter($passw);

$message="
Bonjour Monsieur ".$nom."  <br><br>
Peut etre avez vous eu quelques problemes au niveau du bon de commande<br>
Pour continuer votre commande vous devez vous connecter a votre console d administration.<br>
La console d'administration est a l adresse: http://admin3.kt-centrex.com<br>
Une fois connecté vous devez cliquer sur la rubrique catalogue<br>  
Recapitulatif des informations d'acces au service :<br><br>
Votre login : ".$pseudo."<br>
Votre mot de passe  :".$mpass."<br><br>
Votre console d'administration vous permet, a partir de votre compte de voir votre bon de commande,de changer votre bon de commande et de aboutir a votre commande.<br><br>
Cordialement<br>
kt-centrex<br>
support technique: support.com<br>
";


$messageHTML = "<html><head><title></title></head><body>".stripslashes($message)."<br><br>".$signature."</body>";

	
$queryy = " SELECT * FROM facture WHERE idclient=$numero ";
$mysql_resulty = mysql_query($queryy) or die ("Erreur : ".mysql_error());
if(mysql_num_rows($mysql_resulty) == 0){

mysql_query("insert into mailstosend(email,objet,message,entete,idsignature) "
."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."','$idsignature'"
.") ") or die ("Erreur : ".mysql_error());


if($nbrelance==2){$next=5;}
if($nbrelance==5){$next=15;}
if($nbrelance==15){$next=30;}
if($nbrelance==30){$next=45;}
if($nbrelance==45){$next="closed";}

$daterelance=datePlus($datej,$next);


$sql2 = "UPDATE identite SET  nbrelance='".$next."',daterelance='".$daterelance."'
WHERE numero ='".$numero."'";
$res=mysql_query($sql2);

}
else 
{

$queryy2 = " SELECT * FROM facture , elementfacture WHERE elementfacture.idfacture=facture.id AND (prix < 2 OR paiement!=2) AND idclient=$numero";
$mysql_resultyh2 = mysql_query($queryy2) or die ("Erreur : ".mysql_error());
//echo mysql_num_rows($mysql_resultyh);
if(mysql_num_rows($mysql_resultyh2) > 0){

mysql_query("insert into mailstosend(email,objet,message,entete,idsignature) "
."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."','$idsignature'"
.") ") or die ("Erreur : ".mysql_error());


if($nbrelance==2){$next=5;}
if($nbrelance==5){$next=15;}
if($nbrelance==15){$next=30;}
if($nbrelance==30){$next=45;}
if($nbrelance==45){$next="closed";}

$daterelance=datePlus($datej,$next);
$sql2 = "UPDATE identite SET  nbrelance='".$next."',daterelance='".$daterelance."'
WHERE numero ='".$numero."'";
$res=mysql_query($sql2);

}



}
}
?>