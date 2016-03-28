<?php
require("haut.php");

//On enregistre le mail
	if(isset($modif) && $modif=="ok")
	{
		$query = "update mailparametre set "
		."nom = '$nom', "
		."signature = '".mysql_real_escape_string($signature)."' "
		." where numero='$idpara' ;";
				
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	else
	{
		$query = "insert into mailparametre (nom,signature) "
				." values('$nom','".mysql_real_escape_string($signature)."')";
		mysql_query($query) or die ("Erreur : ".mysql_error());
	}
	//Fin enregistrement
	
echo "<br><center><font color='green' size='4'>Parametre enregistr&eacute; avec succ&egrave;!!!</font></center>";

?>