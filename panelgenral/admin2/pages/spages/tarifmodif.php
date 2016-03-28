<?php

$query = " SELECT * FROM prix ";
$query .= " where numero = '$lenumero'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $numero = ($row["numero"]);
    $pays = ($row["pays"]);
    $extension = ($row["extension"]);
    $prix1 = ($row["prix"]);
    $prix2 = ($row["prix2"]);
    // $idnumero = ($row["numero"]);
}


?>

<br> <br>

<table align="center" class="form">
<form action="?">

<thead><tr><td colspan="2">Modification d'un tarif</td></tr></thead>
<tfoot><tr><td colspan="2"><INPUT type="submit" value="Enregistrer" name="submit"></td></tr></tfoot>


<input type="hidden" name="page" value="tarif" >
<input type="hidden" name="a" value="update" >

<input type="hidden" name="numero" value="<?php print("$numero"); ?> " >

       <tr>
	  <td class="label">Pays :</td>
	  <td class="input"><input size="30" name="pays" value ="<?php print("$pays"); ?> "></td>
	  </tr>

	  <tr>
	  <td class="label">Extension :</td>
	  <td class="input"><input size="30" name="extension" value= "<?php print("$extension");?>" ></td>
	  </tr>

      <!--tr>
	  <td class="label">Le Prix :</td>
	  <td class="input"><input size="30" name="prix" value="<?php //print("$prix1");?>" ></td>
	  </tr-->
	  <tr>
	  <td class="label">Le Prix :</td>
	  <td class="input"><input size="30" name="prix2" value="<?php print("$prix2");?>" ></td>
	  </tr>
      <tr>
	  <td class="label"><blink><font color="red" size="4">Type de prix :</font></blink></td>
	  <td class="input"><input name="type_prix" type="radio" value="ht" checked="checked">H.T.&nbsp;
			<input name="type_prix" type="radio" value="ttc">T.T.C.
	  </td>
	  </tr>
	  
</FORM>

</table>
