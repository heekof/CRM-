<?php



?>



<br> <br>
<table border="0" align="center" width="100%"  >
<tr bgcolor="#CCCCCC"  align="center" >
<td> <b> Numero </b> </td>
<td> <b> Nom </b> </td>
<td> <b> Prenom </b> </td>
<td> <b> Email</b> </td>
<td> <b> Telephone </b> </td>
<td> <b> Appelez </b> </td>
</td>



<?php


// *****************************************
// selection compte par rapport a facture
// require("connecte/base.php");
// print("test ");

$query = " SELECT  * ";
$query .= "FROM  rappel1 order by numero desc  ";
// $query .= "WHERE etat = 'ok' ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$ligne = 0;
while($row = mysql_fetch_array($mysql_result))
{
    $Tnumero = ($row["numero"]);
    $nom = ($row["nom"]);
    $prenom = ($row["prenom"]);
    $email = ($row["email"]);
    $telephone = ($row["telephone"]);
   

    $ajout1++;
// $crypTnumero = crypter($Tnumero);

if($ajout1 < 15) 
{
?>


<tr align="center" <?php echo 'class="ligne_'.($ligne%2).'"'?>>
<td> <?php print("$Tnumero"); ?> </td>
<td>  <?php  print("$nom"); ?> </td>
<td>  <?php  print(" $prenom "); ?> </td>
<td>  <?php  print(" $email "); ?> </td>
<td>  <?php  print("$telephone"); ?> </td>





<td> 

<a href="?page=rappel&lenumero=<?php print("$Tnumero") ?>&a=2&letel=<?php print("$telephone") ?> "> <font color="#996600" size="2" > Go  </font> </a>
 </td>
</td>
<?php
$ligne ++;
}
}

 ?>
</table>
<br> <br>


<?php
// ** insert dans 

if($a == '2')
{

print("insertion  letel $letel ");


 require("insertionumero.php");

}




// ** insertion pour appel

if($a == '3')
{

print("insertion  letel $letel pour appel le numerp ");

require("appelcrm.php");

}


?>


