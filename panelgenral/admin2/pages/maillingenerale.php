<?php
//require("haut.php");
 ?>
</html>
</td>
</table>

<p><br>

<?php
$Tfile_path = explode('/',$_SERVER['PHP_SELF']);
$ch = "";
for($i=0; $i<count($Tfile_path)-1; $i++) $ch .= $Tfile_path[$i]."/";
$url = "http://".$_SERVER['HTTP_HOST'].$ch."voir.php";
		
 $headers ='From: "Admin ktcentrex" <'.$email1.'>'."\n";
 $headers .='Reply-To: '.$email1.''."\n";
 $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
 $headers .='Content-Transfer-Encoding: 8bit';

//require("base.php");
$messageHTML = "<html><head><title></title></head><body>".stripslashes($message);

if($etat == '3')
{
	//On enregistre le mail
	if(isset($modif) && $modif=="ok")
	{
		$query = "update lesmails set "
		."type = 'Membres', "
		."expediteur = '".mysql_real_escape_string($email1)."', "
		."destinataire = 'Tous nos membres', "
		."objet = '".mysql_real_escape_string($objet)."', "
		."message = '".mysql_real_escape_string($message)."', "
		."datemodif = '".date('Y-m-d H:i:s',time())."' where numero='$idmail' ;";
		
		//print $query'<br/>';
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	else
	{
		$query = "insert into lesmails (type,expediteur,destinataire,objet,message,date,datemodif) "
				." values('Membres','".mysql_real_escape_string($email1)."','Tous nos membres','".mysql_real_escape_string($objet)."','".mysql_real_escape_string($message)."','".date('Y-m-d H:i:s',time())."','".date('Y-m-d H:i:s',time())."')";
		//print $query'<br/>';
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	//Fin enregistrement
$query = " SELECT * FROM identite";
//print $query'<br/>';
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    //$nomgroupe = ($row["numgroup"]) ;
    $email = ($row["email"]) ;
    $nom = ($row["nom"]) ;
    $prenom = ($row["prenom"]) ;

	$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?email=".$email."'>ici</a>"
			."<br><br>"
			."-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>"
			."</body>";
    //On mets dans la fils de lancement
    //if(mail($email,stripslashes($objet),$messageHTML, $headers))
	{
		mysql_query("insert into mailstosend(email,objet,message,entete) "
		."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."'"
		.") ") or die ("Erreur : ".mysql_error());
	}
}
echo "<br><center><font color='green' size='4'>Mails de Membres envoi&eacute;s avec succ&egrave;!!!</font></center>";

}

if($etat == '2')
{
	//On enregistre le mail
	if(isset($modif) && $modif=="ok")
	{
		$query = "update lesmails set "
		."type = 'Production', "
		."expediteur = '".mysql_real_escape_string($email1)."', "
		."destinataire = '$id_base', "
		."objet = '".mysql_real_escape_string($objet)."', "
		."message = '".mysql_real_escape_string($message)."', "
		."datemodif = '".date('Y-m-d H:i:s',time())."' where numero='$idmail' ;";
		//print $query'<br/>';	
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	else
	{
		$query = "insert into lesmails (type,expediteur,destinataire,objet,message,date,datemodif) "
				." values('Production','".mysql_real_escape_string($email1)."','$id_base','".mysql_real_escape_string($objet)."','".mysql_real_escape_string($message)."','".date('Y-m-d H:i:s',time())."','".date('Y-m-d H:i:s',time())."')";
		//print $query'<br/>';
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	//Fin enregistrement
$query = " SELECT * ";
$query .= " FROM baseclient  where nombase = '$id_base' ";
print $query'<br/>';
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    //$nomgroupe = ($row["numgroup"]) ;
    $email = ($row["email"]) ;
    $nom = ($row["nom"]) ;
    $prenom = ($row["prenom"]) ;

	$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel&email=".$email."'>ici</a>"
			."<br><br>"
			."-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>"
			."</body>";
    //On mets dans la fils de lancement
    //if(mail($email,stripslashes($objet),$messageHTML, $headers))
	{
		mysql_query("insert into mailstosend(email,objet,message,entete) "
		."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."'"
		.") ") or die ("Erreur : ".mysql_error());
	}
}
echo "<br><center><font color='green' size='4'>Mails de Production envoi&eacute;s avec succ&egrave;!!!</font></center>";
}

if($etat == '1')
{
	//On enregistre le mail   mysql_real_escape_string()
	if(isset($modif) && $modif=="ok")
	{
		$query = "update lesmails set "
		."type = 'Test', "
		."expediteur = '".mysql_real_escape_string($email1)."', "
		."destinataire = '".mysql_real_escape_string($email)."', "
		."objet = '".mysql_real_escape_string($objet)."', "
		."message = '".mysql_real_escape_string($message)."', "
		."datemodif = '".date('Y-m-d H:i:s',time())."' where numero='$idmail' ;";
		//print $query'<br/>';	
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	else
	{
		$messageHTML .= "<br><br>"
			/*."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?n=".$row["numero"]."'>ici</a>"
			."<br><br>"*/
			."-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>"
			."</body>";
		$query = "insert into lesmails (type,expediteur,destinataire,objet,message,date,datemodif) "
		//print $query'<br/>';
				." values('Test','".mysql_real_escape_string($email1)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($objet)."','".mysql_real_escape_string($message)."','".date('Y-m-d H:i:s',time())."','".date('Y-m-d H:i:s',time())."')";
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	//Fin enregistrement
	if(mail($email,stripslashes($objet),$messageHTML, $headers))
	
	echo "<br><center><font color='green' size='4'>Mail de test envoi&eacute; avec succ&egrave;!!!</font></center>";
}
?>

</html>