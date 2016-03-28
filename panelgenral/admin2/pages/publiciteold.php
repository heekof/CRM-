<?php
	//require("pages/mailling/haut.php");
	$title = "Publicite";
	$spage =$_GET['spage'];
	if(!isset($spage)) $spage = 'publicite';
	//var_dump($spage);
	include('./pages/spages/'.$spage.'.php');
?>