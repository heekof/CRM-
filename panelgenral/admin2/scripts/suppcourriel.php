<?php
$Tfile_path = explode('/',$_SERVER['PHP_SELF']);
$ch = "";
for($i=0; $i<count($Tfile_path)-1; $i++) $ch .= $Tfile_path[$i]."/";
$url = "http://".$_SERVER['HTTP_HOST'].$ch;

require_once('config.php');
require_once('lib/mysql.php');


mysql_auto_connect();

if(!isset($email) && !$email)
{
	echo '<center><form action="voir.php?page=suppsourriel&ok=ok" method="POST">';
	echo '<input type="hidden" name="page" value="suppsourriel">';
	echo 'Votre e-mail&nbsp;&nbsp;<input type="text" name="email" size="40">';
	echo '&nbsp;&nbsp;<input type="submit" value="Valider">';
	echo '</form><center>';
}
else
{
mysql_query(" delete from baseclient where email='$email'");


echo '<center><b>Votre courriel a &eacute;t&eacute; supprim&eacute; de notre base.<br>'
	.'Desormais vous ne recevrez plus de mail publicitaire venant de Ktis!</b></center>';
}

mysql_auto_close();
?>