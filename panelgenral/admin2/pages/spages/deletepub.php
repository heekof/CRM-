<?php
$mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");
mysql_select_db("testcentrex", $mysql_link);

$sqldelete="DELETE FROM pub WHERE numpub='".$_GET['numpub']."'";
$resultat = mysql_query($sqldelete);
header("Location:http://support.kt-centrex.com/panelgenral/admin2/?page=publicite&spage=listedepub");
?>