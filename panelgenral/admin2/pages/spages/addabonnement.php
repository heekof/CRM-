<?php
//require("lib/date.php");
if(isset($_GET['f'])){
$f=$_GET['f'];

$qc = @mysql_query(" SELECT * FROM facture WHERE id = '".$f."'");
$obc = mysql_fetch_array($qc);
$idcl=$obc['idclient'];



}

if(isset($_POST['add'])){

$q = @mysql_query(" SELECT * FROM element WHERE id = '".$_POST['objet']."'");
$ob = mysql_fetch_array($q);
$objet=$ob['nom'];

$idclient=$_POST['idclient'];
$periodicite=$_POST['periodicite'];
$description=$_POST['description'];
$idfacture=$_POST['idfacture'];
$montant=$_POST['montant'];
$etat=$_POST['etat'];

$datedebut=time();
$datefin=$datedebut + (24 * 60 * 60 * $periodicite);
//$newDate = date("Y-m-d", $datefin);
mysql_query('insert into abonnementclients(idclient,idexterieur,periodicite,description,objet,datedebut,dateecheance,montant,etat) values("'.$idclient.'","'.$idfacture.'","'.$periodicite.'","'.$description.'","'.$objet.'","'.$datedebut.'","'.$datefin.'","'.$montant.'","'.$etat.'")') or die ("Erreur : ".mysql_error());
$s = mysql_insert_id();
mysql_query('UPDATE facture SET idabonnement = \''.$s.'\' WHERE id = \''.$idfacture.'\';');
echo "<center><p style='color:green;font-weight:bold;font-size:12px;font-family:verdana;'>Abonnement enregistré avec succès </p></center>";
}


?>
<table border="0" align="center" width="70%" class="form">
<!--form action="crm1.php"  id="formCamp" onsubmit="return checkCamp();"-->
<form action="" method="post"   >
        <input type="hidden" name="page" value="addabon" />
      <input type="hidden" name="spage" value="addabonnement" />
<thead>
	<tr><td colspan="2">Creation d'un abonnement </td></tr>
</thead>
 
	<tr > 
		<td > 
			
			<b>&nbsp;Description de l'abonnement :</b>  
		</td> 
		<td  class="input">
			<!--input type="text" name="nomcampagne" id="inputCamp" onchange="checkCamp();"-->
			<input type="text" name="description" id="inputCamp">
		</td> 
	</tr>
	<tr > 
		<td > 
			
			<b>&nbsp;Objet de l'abonnement :</b>  
		</td> 
		<td  class="input">
			<?php
	
	//Récupère les éléments disponibles
	if($r_elt = @mysql_query(" SELECT * FROM element "))
	{
		echo '<select name="objet" id="elements" onchange="getPrixElement();">'
			.'<option value="0">-&nbsp;&nbsp;&nbsp;&nbsp;Choisir un &eacute;l&eacute;ment&nbsp;&nbsp;&nbsp;-</option>';
		
		while($elt = mysql_fetch_array($r_elt))
		{
			echo '<option value="'.$elt['id'].'" title="'.$elt['description'].'">'.$elt['nom'].'</option>';
		}
		echo '</select>';
	}
	?>
		</td> 
	</tr>

	<tr >
		<td class="label"> <B>
		&nbsp;Periodicite :
			</b> 
		</td> 
		<td class="input">
			<input type="text" name="periodicite" style="width:100px;"> jours
		</td>
	</tr>

	
		<tr >
		<td class="label"> <B>
		&nbsp;Montant :
			</b> 
		</td> 
		<td class="input">
			<input type="text" name="montant" style="width:100px;">
		</td>
	</tr>
		<tr >
		<td class="label"> <B>
		&nbsp;Etat :
			</b> 
		</td> 
		<td class="input">
			<input type="radio" name="etat" value="on"> on &nbsp;&nbsp;<input type="radio" name="etat" value="off" checked="checked"> off
		</td>
	</tr>
	<tr >
		<td class="label"> <B>
		&nbsp;Id facture :
			</b> 
		</td> 
		<td class="input">
			<input type="text" name="idfacture" style="width:100px;" value="<?php echo $f?>">
		</td>
	</tr>
	<tr > 
		<td  class="label"> <b> 
&nbsp;Associer un client a cet abonnement :</b>  
		</td>
		<td> <B>

			<SELECT name="idclient" >
			<?php
			$query4 = " SELECT * FROM identite ORDER BY nom";
            $mysql_result4 = mysql_query($query4) or die ("Erreur : ".mysql_error());
            while($rowf = mysql_fetch_array($mysql_result4))
                              {
							          $nom = ($rowf["nom"]);
									  $idclient = ($rowf["numero"]);
									  $prenom = ($rowf["prenom"]);
?>
			<OPTION value="<?php print("$idclient"); ?>" <?php if($idcl==$idclient){echo'selected="selected"';}?>> <?php print("$idclient"); ?>&nbsp;&nbsp;<?php print("$nom"); ?>&nbsp;&nbsp;<?php print("$prenom"); ?></option>
			<?php
			  }
			  
			?>
			</SELECT>

				</b> 
			</td> 
		</tr>


<tr >
		<td class="label">
		</td> 
		<td class="input">
			
		</td>
	</tr>
	<tr >
		<td class="label">
		</td> 
		<td class="input">
			
		</td>
	</tr>
		 <br>
		 <input type="hidden" name="add" value="add" />


			<tfoot>
				<tr><td colspan="2"> <input type="submit" value="valider"></td></tr>
			</tfoot>
		

	</form>
</table>
