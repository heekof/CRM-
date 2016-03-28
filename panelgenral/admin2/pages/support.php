
<?php
if($a == '1')
{

// print("ouvrir un ticket ");
require("technique1.php");

}


// *****************************
// enregistrement reponse ticket

if($a == '2')
{

// print("ouvrir un ticket ");
require("technique2.php");

}


if($a == '4')
{

print("supprimer ");
// require("technique2.php");

$query = "UPDATE support  SET etat='ferme',etat3='3' " ;
$query .= "WHERE numclient =' $leclient' ";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());


}

?>

<table align="center" width="90%" bgcolor="#A8A8A8">
<tr align="center" >
     

            <td width="100%" > <br> <a href="panel.php?page=technique2"> <font size="4" ><b>Cliquez ici pour ouvrir un ticket  
 </b><br> </font> </a> <br></td>



</tr>
</table>


<br> <br>
<table border="0" align="center" width="100%"  >
<tr bgcolor="#CCCCCC"  align="center" >
<td> <b> Numero </b> </td>
<td> <b> Date </b> </td>
<td> <b> Produit </b> </td>
<td> <b> Sujet</b> </td>
<td> <b> Etat </b> </td>
<td> <b> Action </b> </td>
</td>



<?php


// *****************************************
// selection compte par rapport a facture
// require("connecte/base.php");
// print("test ");

$query = " SELECT  * ";
$query .= "FROM  support  ";
$query .= "WHERE etat3 = '2' ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$ligne = 0;
while($row = mysql_fetch_array($mysql_result))
{
    $Tnumero = ($row["numero"]);
    $etat = ($row["etat"]);
    $sujet = ($row["sujet"]);
    $message = ($row["message"]);
    $Ietatlectureclient  = ($row["etatlectureclient "]);
    $produit = ($row["produit"]);
   $date = ($row["date"]);
 $lenumclient = ($row["numclient"]);

    $ajout1++;
// $crypTnumero = crypter($Tnumero);

if($ajout1 < 12) 
{
?>


<tr align="center" <?php echo 'class="ligne_'.($ligne%2).'"'?>>
<td> <?php print("$Tnumero"); ?> </td>
<td>  <?php  print("$date"); ?> </td>
<td>  <?php  print(" $produit "); ?> </td>
<td>  <?php  print(" $sujet "); ?> </td>
<td>  <?php  print("$etat"); ?> </td>





<td> 

<a href="?page=support&a=1&lenumero=<?php print("$Tnumero") ?>&leclient=<?php print("$lenumclient") ?> "> <font color="#996600" size="2" > Voir  </font> </a>
 </td>
</td>
<?php
$ligne ++;
}
}

 ?>
</table>
<br> <br>

