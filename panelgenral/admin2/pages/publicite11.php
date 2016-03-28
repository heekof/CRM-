<?php
//require("pages/mailling/haut.php");
 $title = "Publicite";
 var_dump($spage);
if(!isset($spage)) $spage = 'publicite';

include('../pages/spages/'.$spage.'.php');
?>