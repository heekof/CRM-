<?php
require_once('../config.php');
require_once('../lib/mysql.php');
mysql_auto_connect();
/*********************************************/
if($id)
{
	$r_Elt = mysql_query('SELECT * FROM element where id="'.$id.'" ;');
	$elt = mysql_fetch_array($r_Elt);
	echo $elt['prix'];
}
else echo "";
/*********************************************/
mysql_auto_close()
?>