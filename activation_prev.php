<br> <br>

<?php




include('menupreview.php');
//print("page $page centrex $centrex ");
//echo "la page est :".$page;
$a = "0";

require("connecte/base.php");
require("lib/date.php");



//print("centrex $centrex "); 
$query = " SELECT DISTINCT nombase ";
$query .= " FROM base_client where numcli = '$centrex' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $nombase = ($row["nombase"]) ;
    $numero = ($row["numero"]) ;
    $Tnombase[$a] = $nombase ;
    $Tnumero[$a] =$numero ;

    $a++;
}


?>

<table border="0" align="center" width="70%" class="form">
<!--form action="crm1.php"  id="formCamp" onsubmit="return checkCamp();"-->
<form action="crm1.php"  id="formCamp">
<thead>
	<tr><td colspan="2">Creation d'une campagne </td></tr>
</thead>
 
	<tr > 
		<td > 
			<h2 id="errCamp" style="color:red"></h2>
			<b> Nom de la campagne :</b>  
		</td> 
		<td  class="input">
			<!--input type="text" name="nomcampagne" id="inputCamp" onchange="checkCamp();"-->
			<input type="text" name="nomcampagne" id="inputCamp">
		</td> 
	</tr>
	<tr >
		<td class="label"> <B>
		Date de début
			</b> 
		</td> 
		<td class="input">
			<select name="jdebut">
			<?php
				for($i=1; $i<=31; $i++)
				{
				echo '<option value="'.$i.'" ';
				if($i == $auj_j) echo ' selected="selected" ';
				echo '>'.$i.'</option>';
				}
			?>
			</select>
			<select name="mdebut">
			<?php
				for($i=1; $i<=12; $i++)
				{
				echo '<option value="'.$i.'" ';
				if($i == $auj_m) echo ' selected="selected" ';
				echo '>'.htmlentities($Tabmois[$i]).'</option>';
				}
			?>
			</select>
			<select name="adebut">
			<?php
				for($i=1900; $i<=2050; $i++)
				{
				echo '<option value="'.$i.'" ';
				
				if($i == $auj_a) echo ' selected="selected" ';
				echo '>'.$i.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr >
		<td class="label"> <B>
		Date de fin
			</b> 
		</td> 
		<td class="input">
			<select name="jfin">
			<?php
				for($i=1; $i<=31; $i++)
				{
				echo '<option value="'.$i.'" ';
				if($i == $auj_j) echo ' selected="selected" ';
				echo '>'.$i.'</option>';
				}
			?>
			</select>
			<select name="mfin">
			<?php
				for($i=1; $i<=12; $i++)
				{
				echo '<option value="'.$i.'" ';
				if($i == $auj_m) echo ' selected="selected" ';
				echo '>'.htmlentities($Tabmois[$i]).'</option>';
				}
			?>
			</select>
			<select name="afin">
			<?php
			
				for($i=1900; $i<=2050; $i++)
				{
				echo '<option value="'.$i.'" ';
				
				if($i == $auj_a) echo ' selected="selected" ';
				echo '>'.$i.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<tr > 
		<td  class="label"> <b> Nom du produit :</b>  </td> 
		<td class="input">
			<input type="text" name="nomproduit">
		</td> 
	</tr>
	<tr > 
		<td  class="label"> <b> 
			<font color="red">
			*
			</font>Associer une base a votre campagne </b>  
		</td>
		<td> <B>

			<SELECT name="mbase">
			<?php
			  for($a=0; $a < count($Tnombase); $a++)
			  {
			if(1 < strlen($Tnombase[$a]))
			{
			?>

			<OPTION value="<?php print("$Tnombase[$a]"); ?>"> <?php print("$Tnombase[$a]"); ?> </option>
			<?php
			  }
			  }
			?>
			</SELECT>

				</b> 
			</td> 
		</tr>

	<tr>
		<td colspan="2">
		<table border="1" width="100%" style="font-size:12px;font-weight:bold;">
			<tr>
				<td align="center">
				<b> Choisissez des formulaires pour la campagne </b>
				</td>
			<tr>
			
			<tr>
				<td align="center">
				<input type="checkbox" name="fiche[]" value="qcm" id="qcm" >QCM 
     <!--				<font color="red">*</font>      -->
	 			
				
				


				
				                 
				<input type="checkbox" name="fiche[]" value="rdv" >RDV 
				<!--input type="checkbox" name="fiche[]" value="rmq" >Remarques |--> 
				<input type="checkbox" name="fiche[]" value="qbinaire" >Question binaire 
				<input type="checkbox" name="fiche[]" value="contrat" >Contrat 
				<input type="checkbox" name="fiche[]" value="argument" >Argument 
				</td>
			<tr>
		</table>
		</td>
	</tr>

		 <br>
		  <?php
				$etat = "activapreview";//On passe une fois à l'enregistrement
		  ?>

		  <input type="hidden" name="page" value="<?php print("$etat")?>" >
		 <?php

		    if($a > 0)
		      {
		      // print(" superieure ");


		 ?>
			<tfoot>
				<tr><td colspan="2"> <input type="button" value="Suivant" onclick="checkCamp();"/></td></tr>
			</tfoot>
		 
		  <?php
		     }
		     else
		       {
		        // print("<b> vous devez creer une base qui sera associé a votre campagne </b> ");
		         $drapeau = "1";// je dois remettre le drapeau a 0 pour interdire la création d'une campagne sans base
		       }
		  ?>

	</form>
</table>

<table border="1" align="center" width="70%">

<tr>
<td> <br> <br>

<font color="red" size="3" >

<?php
if($drapeau == "0")
{
?>
<center>
<b>Vous devez creer une base avant de creer une campagne </b>
</center>

<?php
}
?>
</font>
<br>
<br>

 <td >

</tr>
</table>
