<?php
require_once('../config.php');
require_once('../lib/mysql.php');

mysql_auto_connect();

function check_mail($mail)
{
	return (bool)preg_match('/^[a-zA-Z0-9\.\-_]+@[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*$/', $mail);
}

$query = " SELECT * FROM mailstosend where etat='no' ;";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    //$nomgroupe = ($row["numgroup"]) ;
    $numero = ($row["numero"]) ;
    $email = ($row["email"]) ;
    $objet = ($row["objet"]) ;
    $messageHTML = ($row["message"]) ;
    $headers = ($row["entete"]) ;

    if(check_mail($email))
	{
		if(mail($email,stripslashes($objet),$messageHTML, $headers))
		echo "<center><h3>Envoié à $email : $objet</h3></center><br>";
	}else
		echo "<center><h3>Mauvais courriel : $email</h3></center><br>";
	mysql_query("update mailstosend set etat='ok' where numero='$numero'");
	sleep(2);
}

mysql_auto_close();
?>