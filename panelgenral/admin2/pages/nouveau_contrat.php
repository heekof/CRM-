<?php /* facturation.php */

if(!isset($spage)) $spage = 'ajout_contrat';
//echo 'teste'.$_GET['spage'];


include('./pages/spages/'.$_GET['spage'].'.php');
?>