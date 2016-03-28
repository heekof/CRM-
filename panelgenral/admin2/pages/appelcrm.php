
<?php

$query = " INSERT INTO appel (numerocli,numvice,etat,type)";
$query  .= " VALUES ('$letel','$lenumero','no','preview')";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());

?>

