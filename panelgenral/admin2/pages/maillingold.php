<?php
//require("pages/mailling/haut.php");
 $title = "Mailling";
 $spage =$_GET['spage'];
if(!isset($spage)) $spage = 'index';
//var_dump($spage);
include('./pages/mailling/'.$spage.'.php');
?>
