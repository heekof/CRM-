<?php
$inc = "0";
// print("page $page ");


require("connecte/base.php");
require_once('lib/paging.php');
echo '<br><br>';
include('menupreview.php');

$base_url = '';

$query = " SELECT  * ";
$query .= " FROM preview where numcli = '$centrex' ";

$r = mysql_query($query);

if($nb = mysql_num_rows($r))
	$page_count = page_count($nb);
else 
	$page_count = 1;
$page = page_get($page_count);
$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;

$navbar = '<div class="navbar">'
		.'<div class="pages">Page: '.page_build_menu('?page=preview'.$base_url.'&p=', $page, $page_count).'</div>'
		.'</div>';

$query = " SELECT  * ";
$query .= " FROM preview where numcli = '$centrex' "
		.' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE;
		

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$i = "0";

/***********************************************/


while($row = mysql_fetch_array($mysql_result))
{
	$numetrang = ($row["numetrang"]) ;
	$matable = ($row["matable"]) ;
	$etat = ($row["etat"]) ;
	$numero = ($row["numero"]) ;
	$nomchamp = ($row["nomchamp"]) ;
	$dated    = ($row["datedebut"]) ;
	$datef    = ($row["datefin"]) ;
	$nomprod    = ($row["nomproduit"]) ;
	
	$Tmatable[$inc] = $matable ;
	$Tstatut[$inc] = $etat ;
	$Tnumero[$inc] = $numero ;
	$Tnomchamp[$inc] = $nomchamp;
	$Tdated[$inc]    = $dated ;
	$Tdatef[$inc]    = $datef ;
	$Tnomprod[$inc]    = $nomprod ;

	$inc++;
}

// print(" <br>  inc $inc <br> ");

?>
<br>
<h2 align="center" title="listes des campagnes">
	Liste des campagnes b
</h2>
<?php

?>

<?php
if($inc > 0 )

{
	echo $navbar;
?>

 <br>
<table border="0" align="center" width="100%">
	<tr bgcolor="#CCCCCC">
		<td> <center><b> NOM CAMPAGNE </b></center> </td>
		<td> <center><b> NOM PRODUIT </b></center> </td>
		<td> <center><b> DATE DEBUT </b></center> </td>
		<td> <center><b> DATE FIN </b></center> </td>
		<td> <center><b> BASE ASSOCIEE</b> </center>  </td>
		<td> <center><b> ETAT </b> </center> </td>
		<td> <center><b> ACTION </b> </center> </td>
	</tr>

 <?php
 for($a=0; $a < $inc ; $a++)
 {
	
 ?>

	<tr <?php echo 'class="ligne_'.($a%2).'"'?>>
		<td>
			<?php
			 print("<center> $Tnomchamp[$a] </center> ");

			?>
		</td>
		<td>
			<?php
			 print("<center> $Tnomprod[$a] </center> ");

			?>
		</td>
		<td>
			<?php
			$ladate1 = explode(' ',$Tdated[$a]);
				$ladate = explode('-',$ladate1[0]);
			 //print("<center> $Tdatef[$a] </center> ");
			 print("<center> ".$ladate[2]."/".$ladate[1]."/".$ladate[0]." </center> ");
			?>
		</td>
		<td>
			<?php
				$ladate1 = explode(' ',$Tdatef[$a]);
				$ladate = explode('-',$ladate1[0]);
			 //print("<center> $Tdatef[$a] </center> ");
			  print("<center> ".$ladate[2]."/".$ladate[1]."/".$ladate[0]." </center> ");
			 
			?>
		</td>
		<td>
			<?php
			$montetat = $Tstatut[$a];
			$monumero = $Tnumero[$a];

			print("<center> <b> $Tmatable[$a] </b> </center> ");

			?>
		</td>
		<td>
			<?php
			if($montetat=='ok')
			print("<center> <b> Activ&eacute;e </b> </center> ");
			elseif($montetat=='no')
			print("<center> <b> Desactiv&eacute;e </b> </center> ");

			?>
		</td>
		<td>

			<?php
			if (strcasecmp($montetat,'att') <> 0 )
			{
			?>
				 <br>
				<form action="crm1.php">
				<input type="hidden" name="page" value="mpredictif" >
				<input type="hidden" name="monumero" value="<?php print("$monumero");?> " >

				<SELECT name="campagne">

				<OPTION VALUE="2" selected>Desactiver</OPTION>
				<OPTION VALUE="3" <?php if($montetat=='no') echo 'selected="selected"'?>>Activer</OPTION>
				<OPTION VALUE="5">Effacer</OPTION>

				</select>

				<input type="submit" value="Go"/>

				</form>
			<?php
			}else
				print("<br>");
			?>
			<form action="crm1.php?page=reinitCamp" method="POST">
				<input type="hidden" name="page" value="reinitCamp">
				<input type="hidden" name="a" value="reinit">
				<input type="hidden" name="nomchamp" value="<?php print("$Tnomchamp[$a]");?>">
				<input type="hidden" name="monumero" value="<?php print("$monumero");?> " >
				<input type="submit" value="re-initialiser">
			</form>
		</td>
		
	</tr>
	
 <?php
  }
 ?>
 </table>

 <?php
	echo $navbar;
}
 ?>