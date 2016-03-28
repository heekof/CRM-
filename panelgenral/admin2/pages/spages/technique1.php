

<table border="0" align="center" width="100%"  >


<?php


require("connecte/base.php");
// print("test ");
$cryptolenumero = decrypter($lenumero);
// print("cryptolenumero $cryptolenumero ");

$query = " SELECT  * ";
$query .= "FROM  support  ";
$query .= "WHERE numclient = '$centrex'  and etat = 'ouvert' ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$ligne = 0;
while($row = mysql_fetch_array($mysql_result))
{
    $Tnumero = ($row["numero"]);
    $etat = ($row["etat"]);
    $sujet = ($row["sujet"]);
    $message1 = ($row["message"]);
    $Ietatlectureclient  = ($row["etatlectureclient "]);
    $produit = ($row["produit"]);
   $date = ($row["date"]);

    $ajout1++;
$crypTnumero = crypter($Tnumero);
?>

<tr>
<td bgcolor="white">  <?php  print("<BR><B>SUJET :</B> <BR> $sujet"); ?>  </td>

</tr>

<tr>

<td bgcolor="grey" >  <?php  print("<B>MESSAGE : </B> <BR> $message1"); ?> <BR> <br>  </td>
</tr>
<?php
}
?>

</table>


<TABLE BORDER="0" width="%70" align="center">

 <tr width="60%">
	  
	  <td>

<FORM method=post action="panel.php">
</td>
	  </tr>


<tr>
	  
	  <td>


</select>

</td>
	  </tr>

<TR>


	<TD>
<br><br>
<center>


<TEXTAREA rows="17" cols="57" name="data">
	</TEXTAREA>
</center>
<INPUT TYPE="hidden" NAME="page" VALUE="technique3"> 
</TD><Tr>



<INPUT TYPE="hidden" NAME="produit" VALUE="<?php print("$produit");?>"> 
<INPUT TYPE="hidden" NAME="message" VALUE="<?php print("$message"); ?>">
<INPUT TYPE="hidden" NAME="sujet" VALUE="<?php print("$sujet"); ?>">
<TR>

	<TD>
<center>
<br><br>
<INPUT type="submit" value="Enregistrer">
</center>
</TD><Tr>
</FORM>

</table>
<br> <br>


