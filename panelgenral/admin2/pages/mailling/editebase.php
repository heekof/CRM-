<?php

$query = " SELECT * FROM baseclient ";
$query .= " where numero = '$lenum' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
if($row = mysql_fetch_array($mysql_result))
{
    $numero = ($row["numero"]);
    $nom = ($row["nom"]);
    $prenom = ($row["prenom"]);
	$email = ($row["email"]);
    $nombase = ($row["nombase"]);
}

?>
<form action="?page=mailling&amp;spage=voirbase&a=update" method="post">
	
	<input type="hidden" name="lenum" value="<?php print("$numero"); ?>" />
	<input type="hidden" name="lenom" value="<?php print("$lenom"); ?>" />
	<table class="form">
		<thead>
			<tr><td colspan="2">Modification de l'entrée N° <?php echo $lenum;?></td></tr>
		</thead>
		<tfoot>
			<tr><td colspan="2"><input type="submit" value="Valider" /></td></tr>
		</tfoot>
		<tr>
			<td>Nom</td>
			<td class="input"><input type="text" name="nom" value="<?php print("$nom"); ?>" />   </td>
		</tr>

		<tr>
			<td class="label"> Prenom</td>
			<td class="input"><input type="text" name="prenom" value="<?php print(" $prenom"); ?>" />  </td>
		</tr>
		
		<tr>
			<td class="label"> Email</td>
			<td class="input"><input type="text" name="email" value="<?php print("$email"); ?>" />   </td>
		</tr>
		
	</table>
</form>