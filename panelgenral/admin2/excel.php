<?php
$mysql_server = '94.23.22.154';
$mysql_user = 'tshivuadi';
$mysql_password = 'tshivuadi2010';
$mysql_db = 'testcentrex';

$mysql_link = mysql_connect($mysql_server, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $mysql_link);

$message="
Bonjour Monsieur<br>
Ci dessous nos promotions sur nos terminaisons d'appel<br><br>
";

$query = " SELECT * FROM prix WHERE id=1 ORDER BY pays ASC";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());

if(mysql_num_rows($mysql_result) > 0){
	$message.="
		<table>
			<tr>
				<td>Pays</td>
				<td>Extension</td>
				<td>Prix en HT</td>
			</tr>
	";
	while($row = mysql_fetch_array($mysql_result))
								  {
		$pays = ($row["pays"]) ;
		$extension = ($row["extension"]) ;
		$prix = ($row["prix2"]) ;

$pays = strtoupper($pays);
		$message.= "<tr>
				<td>".$pays."</td>
				<td>".$extension."</td>
				<td>".$prix."</td>
			</tr>";
	}
	
	$message.="
	</table><br><br>";
}

$message.="
	Veuillez trouver ci-joint une nouvelle grille tarifaire .<br>
	
	En vous souhaitant bonne réception.
";

$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";



$messageHTML = "<html><head><title></title></head><body>".stripslashes($message);
$objet="envoie liste d'appel";
$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "tarifsktcentrex.xls";

// encode data (puts attachment in proper format)
$file = "tarifs.xls";
$fp = fopen($file, "rb");  
$attachment = fread($fp, filesize($file));
fclose($fp);

$attachment = chunk_split(base64_encode($attachment));

// main header (multipart mandatory)
$headers ='From: "KTcentrex.com" <support@ktcentrex.com>'."\n";
$headers .='Reply-To: support@ktcentrex.com'."\n";
$headers .= "MIME-Version: 1.0".$eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
$headers .= "Content-Transfer-Encoding: 7bit".$eol;
$headers .= "This is a MIME encoded message.".$eol.$eol;

// message
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$headers .= $messageHTML.$eol.$eol;

// attachment
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: application/vnd.ms-excel; name=\"".$filename."\"".$eol;
$headers .= "Content-Transfer-Encoding: base64".$eol;
$headers .= "Content-Disposition: attachment".$eol.$eol;
$headers .= $attachment.$eol.$eol;
$headers .= "--".$separator."--";		


$query = " SELECT  distinct email FROM identite ORDER BY numero ASC;";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    //$nomgroupe = ($row["numgroup"]) ;
    $email = ($row["email"]) ;
    $nom = ($row["nom"]) ;
    $prenom = ($row["prenom"]) ;

	//On mets dans la fils de lancement
    mail($email,stripslashes($objet),$messageHTML, $headers);
}
?>
