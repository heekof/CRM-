<br>
<br>
<table border="0"  align="center" width="60%" >
	<tr align="center">
		<td bgcolor="#CCCCCC"> <b>  Importer une base Externe - csv :3/3 </b>    </td>
	</tr>
</table>
<?php
require("connecte/base.php");
// print("<br> <br> $labase <br> <br> ");

$base_ligne  =  explode("\n",$labase );

$nbe_ligne = count($base_ligne);


for($a=0;$a < $nbe_ligne ; $a++)
{
	$la_ligne = $base_ligne[$a];
	$le_mot = explode($separation,$la_ligne);

	$nom = $le_mot[0];
	$prenom = $le_mot[1];
	$telephone1 = $le_mot[2];

     // $telephone1 = mb_convert_encoding($telephone1,'HTML-ENTITIES',$from_enc);
       $telephone1 = eregi_replace("[^a-z0-9]",'',$telephone1);
       $telephone1=str_replace(' ','',$telephone1); 

	$email = $le_mot[3];
	
	$Toptions = explode('-',$optionsChoisis);
	
	$champs = "(nom,prenom,telephone1,numcli,nombase,email,options_choisis";
	$values = "('$nom','$prenom','$telephone1','$centrex','$nominsertion','$email','$optionsChoisis'";
	if(count($Toptions)&&$Toptions[0])
	for($i=1;$i<count($Toptions); $i++)
	{
		$lop = $Toptions[$i-1];
		$valOption = $le_mot[3+$i];
		$type      = ${'typeoption'.$lop};
		$label     = ${'labeloption'.$lop};
			
		$champs .= ',option'.$lop.',typeoption'.$lop.',labeloption'.$lop;
		$values .= ",'$valOption','$type','$label'";
	}
	$champs .= ')';
	$values .= ')';
	$query = " INSERT INTO base_client ".$champs." ";
	$query  .= " VALUES ".$values." ";
	$result = mysql_query($query) or die ("Erreur : ".mysql_error());
}
?>
<br> <br>
<center> <b> Enregistrement avec succés  !! </b> </center>
<br> <br> <br> <br>
