<?php
if(isset($a) && $a=="update")
{
	if($type_prix=="ht") {$leprix = $prix ;$leprix2 = $prix2 ;}
	else if($type_prix=="ttc") {$leprix =  ($prix/1.196);$leprix2 =  ($prix2/1.196);}

	$query = " UPDATE prix SET pays='$pays',extension='$extension',prix2='$leprix2' " ;//,prix='$leprix'
	$query .= " WHERE numero=' $numero' ";
	$result = mysql_query($query) or die ("Erreur : ".mysql_error());
	echo '<center><b> Tarif modifi&eacute; avec succ&egrave;s !!! </b> </center>';
}
if(isset($a) && $a=="add")
{
	if($type_prix=="ht") {$leprix = $prix ;$leprix2 = $prix2 ;}
	else if($type_prix=="ttc") {$leprix =  ($prix/1.196);$leprix2 =  ($prix2/1.196);}

	$query = " insert into prix (pays,extension,prix2) values('$pays','$extension','$leprix2') " ;
	$result = mysql_query($query) or die ("Erreur : ".mysql_error());
	echo '<center><b> Enregistrement avec succ&egrave;s !!! </b> </center>';
}

include('lib/number.php');
if(!isset($variable)) $variable=A;
?>
 <table border="0" width="90%"  align="center">
     <tr BGCOLOR="black" size="4">
     <td>

     <a href="?variable=A&page=tarif"> A </a>
     -
     <a href="?variable=B&page=tarif"> B </a>
      -
     <a href="?variable=C&page=tarif"> C </a>
      -
     <a href="?variable=D&page=tarif"> D </a>
      -
     <a href="?variable=E&page=tarif"> E </a>
      -
     <a href="?variable=F&page=tarif"> F </a>
      -
     <a href="?variable=G&page=tarif"> G </a>
      -
     <a href="?variable=H&page=tarif"> H </a>
      -
     <a href="?variable=I&page=tarif"> I </a>
      -
     <a href="?variable=J&page=tarif"> J </a>
      -
     <a href="?variable=K&page=tarif"> K </a>
      -
     <a href="?variable=L&page=tarif"> L </a>
      -
     <a href="?variable=M&page=tarif"> M </a>
     -
      <a href="?variable=N&page=tarif"> N </a>
      -
     <a href="?variable=O&page=tarif"> O </a>
      -
     <a href="?variable=P&page=tarif"> P </a>
      -
     <a href="?variable=Q&page=tarif"> Q </a>
      -
     <a href="?variable=R&page=tarif"> R </a>
      -
     <a href="?variable=S&page=tarif"> S </a>
     -
     <a href="?variable=T&page=tarif"> T </a>
     -
     <a href="?variable=U&page=tarif"> U </a>
     -
     <a href="?variable=V&page=tarif"> V </a>
     -
     <a href="?variable=W&page=tarif"> W </a>
     -
     <a href="?variable=X&page=tarif"> X </a>
     -
     <a href="?variable=Y&page=tarif"> Y </a>
     -
     <a href="?variable=Z&page=tarif"> Z </a>

     </td>
     </tr>
 </table>
         <table border="0" width="90%"  align="center">

         <tr align="left" BGCOLOR="#C0C0C0"  >
           <td width="25%"> <font size="4">  Destination </font> </td>
		   <td width="10%" > <font size="4"> Indicatif  </font></td>
		   <td width="15%" > <font size="4"> Le Prix H.T.</font></td>
		   <td width="20%"> <font size="4">  Le Prix T.T.C. </font></td>
		   <!--td width="12.5%"> <font size="4"> Le Prix2 H.T </font></td>
		   <td width="15%"> <font size="4"> Le Prix2 T.T.C. </font></td-->
            <td width="10%"> <font size="4"> Modifier</font></td>
         </tr>
         <?php
         $a = "0";
         // print("<br> centrex $centrex <br> ");

$query = " SELECT * FROM prix ";
$query .= "  where pays like '$variable%' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $numero = ($row["numero"]);
    $pays = ($row["pays"]);
    $extension = ($row["extension"]);
    $prix1 = ($row["prix"]);
    $prix2 = ($row["prix2"]);
$a++;
if ($a%2 == 0)
    {
        $couleur = "white";
    }
    else
    {
        $couleur= "#99FFFF";;
    }
$laTVA = 19.6;
?>

  <tr bgcolor="<?php print("$couleur");?>" align="left" >
  <td> <?php print("$pays"); ?> </td>
<td> <?php print("$extension");   ?>   </td>
<!--td> <?php //echo round($prix1,4)."  €";   ?>   </td>
<td> <?php// echo round($prix1*(1 + $laTVA/100),4)."  €"; ?> </td-->
<td> <?php echo round($prix2,4)." € "; ?> </td>
<td> <?php echo round($prix2*(1 + $laTVA/100),4)."  €"; ?> </td>
<td>
   <a href="?page=tarif&spage=tarifmodif&lenumero=<?php print("$numero")?>"> <font color="#996600" size="2" > Go </font> </a>
</td>
 
</tr>

<?php
    // $a++;
}
?>

</table>







