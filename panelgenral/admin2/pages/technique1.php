<?php

$query = " SELECT  * ";
$query .= "FROM  identite  ";
$query .= "WHERE numero = '$leclient' ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$ligne = 0;
while($row = mysql_fetch_array($mysql_result))
{
    $nom = ($row["nom"]);
  $prenom = ($row["prenom"]);
 $nichandle = ($row["nickhandle"]);
 $telephonep = ($row["telephonep"]);
 $prenom = ($row["prenom"]);

}

?>

<table border="1" align="center" width="100%"  >

<tr>
<td>
Nom : <b> <?php  print(" $nom "); ?>   </b> 
<br>
Prenom <b> <?php  print(" $prenom "); ?> </b> 
</td>


<td>
Login client :  <b> <?php  print(" $nichandle"); ?></b> 
<br>
Tel client : <b>  <?php  print(" $telephonep "); ?> </b> 
</td>




<td>
<font size="3" color="red">
RETOUR
</font>
<br>
<font size="3" color="red">

<a href="?page=support&a=4&leclient=<?php print("$leclient") ?> "> 
FERMER LA DISCUTION
</a>

</font>
</td>


<tr>

</table>



<table border="1" align="center" width="100%"  >
<?php


// require("connecte/base.php");
// print("test ");
// $cryptolenumero = decrypter($lenumero);
// print("cryptolenumero $cryptolenumero ");

$query = " SELECT  * ";
$query .= "FROM  support  ";
$query .= "WHERE etat = 'ouvert' and numclient= '$leclient' ";

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
   $etat3 = ($row["etat3"]);
    $ajout1++;
// $crypTnumero = crypter($Tnumero);
?>

<tr>
<td bgcolor="white">  <?php  print("<BR><B>SUJET :</B>  $sujet - :<B> DATE :</B> $date"); ?>  </td>

</tr>

<tr>
<?php  
if($etat3 == '10')
{

 ?> 

<td bgcolor="grey" > 

<?php  

}
else
  {

 ?> 

<td bgcolor="red" > 
<?php  
}


 ?> 

 <?php  print("<B>MESSAGE : </B> <BR> $message1"); ?> <BR> <br>  </td>
</tr>
<?php
}
?>

</table>


<TABLE BORDER="4" width="%70" align="center">

 <tr width="60%">
	  
	  <td>

<FORM method=post action="">
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
<INPUT TYPE="hidden" NAME="page" VALUE="support"> 
</TD><Tr>

<INPUT TYPE="hidden" NAME="numclient1" VALUE="<?php print("$leclient");?>"> 
<INPUT TYPE="hidden" NAME="etat3" VALUE="10"> 
<INPUT TYPE="hidden" NAME="a" VALUE="2"> 
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


