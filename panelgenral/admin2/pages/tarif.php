
<?php
$title= "Nos tarifs";
include("pages/spages/sousmenuTarifs.php");
echo '<br>';
if(!isset($spage)) $spage = 'nostarif';

include('./pages/spages/'.$spage.'.php');

 ?>

