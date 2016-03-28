<?php
$mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");
mysql_select_db("testcentrex", $mysql_link);


$message.="
Bonjour Monsieur <br><br>
Peut etre avez vous eu quelques problemes au niveau du bon de commande<br><br>
Pour continuer votre commande vous devez vous connecter a votre console d administration.<br><br>
La console d'administration est a l adresse: http://admin3.kt-centrex.com<br><br>
Une fois connecté vous devez cliquer sur la rubrique catalogue<br><br>
Recapitulatif des informations d'acces au service :<br><br>
Votre login :<br>
Votre mot de passe :<br><br>
Votre console d'administration vous permet, a partir de votre compte de voir votre bon de<br><br>
commande,de changer votre bon de commande et de aboutir a votre commande.<br><br>
Cordialement<br><br>
kt-centrex<br>
support technique: support.com<br>



";
$objet="commande non terminé";


$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";
						
$headers ='From: "KTcentrex.com" <webkalor@gmail.com>'."\n";
$headers .='Reply-To: webkalor@gmail.com'."\n";
$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';


$messageHTML = "<html><head><title></title></head><body>".stripslashes($message);

$messageHTML .= "<br><br>".$signature."</body>";
			
			
			
$query = " SELECT * FROM identite ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    //$nomgroupe = ($row["numgroup"]) ;
    $email = ($row["email"]) ;
    $numero = ($row["numero"]) ;
    $prenom = ($row["prenom"]) ;
	$nom = ($row["nom"]) ;



	
$queryy = " SELECT * FROM facture , elementfacture WHERE elementfacture.idfacture=facture.id AND prix < 2 AND idclient=$numero";
$mysql_resultyh = mysql_query($queryy) or die ("Erreur : ".mysql_error());
if(mysql_num_rows($mysql_resultyh) > 0){

mysql_query("insert into mailstosend(email,objet,message,entete,idsignature) "
."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."','$idsignature'"
.") ") or die ("Erreur : ".mysql_error());


}}

?>