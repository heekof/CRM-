<?php

//On récupère kles champs optioinnels choisis pour la base


$query = " SELECT nombase FROM baseclient ";
$query .= " where numero = '$lenum' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $nombase = ($row["nombase"]);
}

?>
<br /><br />
<form action="?page=mailling&amp;spage=voirbase&a=add" method="post">
	
	<input type="hidden" name="lenom" value="<?php print("$labase"); ?>" />
	<table class="form">
		
			
		<thead>
			<tr><td colspan="2">Ajout d'une entrée</td></tr>
		</thead>
		<tfoot>
			<tr><td colspan="2"><input type="submit" value="Valider" /></td></tr>
		</tfoot>
		<tr>
			<td>Nom</td>
			<td class="input"><input type="text" name="nom" value="" />   </td>
		</tr>

		<tr>
			<td class="label"> Prenom</td>
			<td class="input"><input type="text" name="prenom" value="" />  </td>
		</tr>
		
		<tr>
			<td class="label"> Email</td>
			<td class="input"><input type="text" name="email" value="" />   </td>
		</tr>
				
	</table>
</form>