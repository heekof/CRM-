<?php

// print("<br> centrex $centrex <br> ");

?>
<br>
<br>
<center><b> Creation -Login & Admin </b> </center>
<br>

<table align="center">
<form action="crm1.php">
 <input type="hidden" name="page" value="enregistrement2" >

<tr>
	  <td class="text">Login :</td>
	  <td><input size="10" name="login"></td>
	  </tr>

	  <tr>
	  <td class="text">Mot de passe :</td>
	  <td><input size="10" name="motdepasse"></td>
	  </tr>

           <tr>
	  <td class="text">Numero interne :</td>
	  <td>

           <SELECT name="numvice" >
          <?php
      
// print("okiiii ");
 $ic = "0";
$query = " SELECT DISTINCT id FROM facture ";
$query .= " where idclient = '$centrex' and paiement = '2'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {
                                     	$monid = ($row["id"]);
                               		// $monnumero = ($row["numero"]);
                               		$Tmonid[$ic] = $monid ;
                                    $ic++;
                              }


print(" <br>  $ic , tmonid $Tmonid[0] , tmoinf $Tmonid[1] <br> ");
 $incre = "0";
for($a=0; $a < $ic ; $a++)
                        {
// $incre = "0";
$lidfacture = $Tmonid[$a];
$query = " SELECT DISTINCT numero FROM compte ";
$query .= " where idfacture = '$lidfacture' and  ajout NOT LIKE 'ok' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {
                                	$mynumero = ($row["numero"]);
                                	$Tmynumero[$incre] = $mynumero ;
                                        $incre++;
                              }
}

for($debut=0; $debut < $incre ; $debut++)
{
     //print("numero: $Tmynumero[$debut] <br> ");
?>

<OPTION VALUE="<?php  print("$Tmynumero[$debut]  "); ?>">  <?php  print("$Tmynumero[$debut] <br> ");?>  </OPTION>

<?php
}

?>
        </select>




          </td>
	  </tr>

	  <tr>
	  <td class="text">Numero externe client :</td>
	  <td><input size="18" name="numinexterne" value="33" ></td>
	  </tr>


          <tr>
	  <td class="text">Campagne Associé :</td>
	  <td>
          


<SELECT name="id_base" >
<?php
// nomchamp
$query = " SELECT DISTINCT nomchamp,numero FROM preview ";
$query .= " where numcli = '$centrex' and etat = 'ok' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {
                                	$nombase = ($row["nomchamp"]);
                               		$monnumero = ($row["numero"]);

?>
		<OPTION VALUE="<?php print("$monnumero") ?>">  <?php print("$nombase") ?>  </OPTION>

        <?php
                              }

        ?>
</SELECT>



          </td>
	  </tr>


          <tr>
               <td> </td>
               <td>
                       <br> <br>
                       <?php
                        // print(" incre $incre <br> ");
                         
                         if($incre > "0")
                         {
                          // print("ok");


                       ?>

                 <INPUT type="submit" value="Enregistrer" name="submit">

                 <?php
                   }
                   else
                    {
                      print("<font color=\"red\">");
                     print("<b>Vous n'avez pas de numero interne disponible , contactez le service commerciale  </b> ");
                    print("</font>");
                    }
                 ?>


</FORM>
                </td>
          </tr>
	  </table>
	  

	   <br> <br>
<table border="0" align="center" width="50%"  >
<tr> <td bgcolor="red"><center><b> <br> <a href="crm1.php?page=gmodifier"> Modifier-Lister-Supprimer </a> </b> </br></center> <br> </td>

</tr>

</table>

