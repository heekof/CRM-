<?php 
$contenaire.=$BB;
include("traitement_arbre.php");

//$Vactuel="Vactuel";
//echo '<br> mon test1='.$test1.'et sa longueur='.strlen($test1) ;

 ?>
 

<!-- le tableau principale -->
<table border="0" align="center" width="100%"  height="100%" cellspacing="0"  cellpadding="0" >
<!-- la forme principale qui retourne les elements dans la meme page -->
 <form method="POST" action="crm1.php?page=arbre" >

 <!-- tr: ligne td:colonnes -->
<tr align="center" style="<?php if(strlen($test1)==0) echo  "display:none;";?>"  >
	<td >	<input  name="A1ds" type="hidden" value="<?php echo "A1"; ?>" size="17" maxlength="200" disabled="disabled" /> 
		 	
			
	</td>		
	  <!-- input hidden pour creer de l'espace -->
	<input  name="A1ds" type="hidden" value="<?php echo "A1"; ?>" size="17" maxlength="200" disabled="disabled" />  	
	<!-- precedent s'affiche si seulement il existe -->
	<td>precedent:<input style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" name="A1" type="<?php if(strlen($test1)!=0) echo "text"; else echo "hidden"; ?>"  value="<?php  if(strlen($test1)!=0)echo $Vheritager; else echo "";  ?>"  size="22" maxlength="100" disabled="disabled" />  
</tr>
<tr>
	<td><input  name="A1ds" type="hidden" value="<?php echo "A1"; ?>" size="17" maxlength="200" disabled="disabled" />  
	<td align="center" width="100" ><input type="<?php if(strlen($test1)!=0) echo "image"; else echo "hidden"; ?>" src="F4.png"  name="F4" value="F4">
</tr>
<tr>
	<td ><input  name="A1ds" type="hidden" value="<?php //echo "A1"; ?>" size="17" maxlength="200" disabled="disabled" /> 
		<!-- bouton retour -->
		<p style="text-align: center;"><input  type="image"  src="haut.png"    name="retour" value="retour"     /> </p>
	</td>	
	<td align="center" >Vous etes la:<TEXTAREA   style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;"  name="A1" type="text"   disabled="disabled" /> <?php  echo substr($Vactuel, 0, 400); ?></TEXTAREA ></td>
</tr>
<tr height="20" > <!-- insertion des images ! (fleches)-->
	<td align="right" width="100"  ><input type="image" src="F1.png"  name="F1" value="F1" style="<?php if($Voui==NULL) echo  "display:none;";?>">
	<td align="center" width="100"  ><input type="image" src="F2.png"  name="F2" value="F2" style="<?php if($Vnon==NULL) echo  "display:none;";?>">
	<td align="left"  width="100" ><input type="image" src="F3.png"  name="F3" value="F3" style="<?php if($Vind==NULL) echo  "display:none;";?>"  >
</tr>
<tr ><!-- insertion des labels ! (texte)-->
	<td  align="center"  ><label style="<?php if($Voui==NULL) echo  "display:none;";?>" ></label><TEXTAREA   style="<?php if($Voui==NULL) echo  "display:none;";?> font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100px; width:100%;" name="A2" type="text" value="<?php echo $Voui; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Voui, 0, 400); ?>  </TEXTAREA>
	<td align="center"   ><label style="<?php if($Vnon==NULL) echo  "display:none;";?>" ></label><TEXTAREA  style=" <?php if($Vnon==NULL) echo  "display:none;";?> font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100px; width:100%;" name="A3" type="text" value="<?php echo $Vnon; ?>" size="17" maxlength="200" disabled="disabled" /> <?php echo substr($Vnon, 0, 400); ?></TEXTAREA>
	<td align="center"  ><label style="<?php if($Vind==NULL) echo  "display:none;";?>" ></label><TEXTAREA  style="<?php if($Vind==NULL) echo  "display:none;";?> font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100px; width:100%;" name="A4" type="text" value="<?php echo $Vind; ?>" size="17" maxlength="200" disabled="disabled" /> <?php echo substr($Vind, 0, 400);?> </TEXTAREA>
</tr>
<tr>
	<td align="center" ><table >
		<td align="right" style="<?php if($Vouioui==NULL) echo  "display:none;";?>"  ><input style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F1.png"  name="F1" value="F1">
		<td align="center"style="<?php if($Vouinon==NULL) echo  "display:none;";?>"  ><input style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F2.png"  name="F2" value="F2">
		<td align="left" style="<?php if($Vouiind==NULL) echo  "display:none;";?>"   ><input style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F3.png"  name="F3" value="F3">
	
	</table></td>
	
	<td align="center"><table > 
		<td align="right"style="<?php if($Vnonoui==NULL) echo  "display:none;";?>" width="100" ><input style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F1.png"  name="F1" value="F1">
		<td align="center" style="<?php if($Vnonnon==NULL) echo  "display:none;";?>" width="100" ><input style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F2.png"  name="F2" value="F2">
		<td align="left" style="<?php if($Vnonind==NULL) echo  "display:none;";?>" width="100" ><input style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F3.png"  name="F3" value="F3">
	
	</table></td>
	<td  align="center"><table>
		<!-- --><td  style="<?php if($Vindoui==NULL) echo  "display:none;";?>" width="100" ><input   style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F1.png"  name="F1" value="F1">
		<td  style="<?php if($Vindnon==NULL) echo  "display:none;";?>" width="100" ><input align="center" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F2.png"  name="F2" value="F2">
		<td  style="<?php if($Vindind==NULL) echo  "display:none;";?>"  width="100" ><input  align="center" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="image" src="F3.png"  name="F3" value="F3">
	
	
	</table></td>
	
</tr>
<tr align="center"><!-- insertion de tableaux dans les cellules pour avoir une taille optimisér! -->
		<td><table border=0 width="100%" height="100%">
		<td align="center"style="<?php if($Vouioui==NULL) echo  "display:none;";?>" ><TEXTAREA name="A8" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="text" value="<?php echo $Vouioui; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vouioui, 0, 100); ?></TEXTAREA><br> <input type="image" src="add.png"  name="BB" value="ouioui"><?php //echo //substr($Vnonoui, 0, 40); ?>
		<td align="center" style="<?php if($Vouinon==NULL) echo  "display:none;";?>" ><TEXTAREA name="A9" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;"  type="text" value="<?php echo $Vouinon; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vouinon, 0, 100); ?></TEXTAREA><br> <input type="image"  src="add.png" name="BB" value="ouinon"><?php //echo// substr($Vnonnon, 0, 40); ?>
		<td align="center" style="<?php if($Vouiind==NULL) echo  "display:none;";?>" ><TEXTAREA name="A10" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;"  type="text" value="<?php echo $Vouiind; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vouiind, 0, 100); ?></TEXTAREA><br> <input type="image" src="add.png"  name="BB" value="ouiind"><?php //echo substr($Vnonind, 0, 40); ?>
		</table ></td>
		<td><table border=0 width="100%" height="100%">
		<td align="center"style="<?php if($Vnonoui==NULL) echo  "display:none;";?>" ><TEXTAREA name="A8" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="text" value="<?php echo $Vnonoui; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vnonoui, 0, 100); ?></TEXTAREA><br> <input type="image"  src="add.png" name="BB" value="nonoui"><?php //echo //substr($Vnonoui, 0, 40); ?>
		<td align="center" style="<?php if($Vnonnon==NULL) echo  "display:none;";?>" ><TEXTAREA name="A9" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;"  type="text" value="<?php echo $Vnonnon; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vnonnon, 0, 100); ?></TEXTAREA><br> <input type="image" src="add.png"  name="BB" value="nonnon"><?php //echo// substr($Vnonnon, 0, 40); ?>
		<td align="center" style="<?php if($Vnonind==NULL) echo  "display:none;";?>" ><TEXTAREA name="A10" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;"  type="text" value="<?php echo $Vnonind; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vnonind, 0, 100); ?></TEXTAREA><br> <input type="image" src="add.png"  name="BB" value="nonind"><?php //echo substr($Vnonind, 0, 40); ?>
		</table ></td>
		<td><table border=0 width="100%" height="100%">
		<td align="center" style="<?php if($Vindoui==NULL) echo  "display:none;";?>" ><TEXTAREA name="A11" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="text" value="<?php echo $Vindoui; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vindoui, 0, 100); ?></TEXTAREA>  <br> <input type="image"  src="add.png" name="BB" value="indoui"><?php //echo substr($Vindoui, 0, 40); ?>
		<td align="center"  style="<?php if($Vindnon==NULL) echo  "display:none;";?>"><TEXTAREA name="A12" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="text" value="<?php echo $Vindnon; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vindnon, 0, 100); ?></TEXTAREA><br> <input type="image" src="add.png"  name="BB" value="indnon"><?php //echo substr($Vindnon, 0, 40); ?>
		<td align="center" style="<?php if($Vindind==NULL) echo  "display:none;";?>" ><TEXTAREA name="A13" style="font-family: Arial Narrow;  font-size: 7 pt; font-weight: bold; height:100%; width:100%;" type="text" value="<?php echo $Vindind; ?>" size="17" maxlength="200" disabled="disabled" /><?php echo substr($Vindind, 0, 100); ?></TEXTAREA>  <br> <input type="image"src="add.png"   name="BB" value="indind"><?php //echo substr($Vindind, 0, 40); ?>
		</table></td>

</tr>
<tr> 

		<a       target="_self"   href="crm1.php?page=jaafar"   ><img src="info3.png"> </a>

</tr>
<!--variable contenaire de type hidden qui me sert à la concaténation  -->
 <input type="hidden"   name="temoin"  value="<?php echo $temoin+1; ?>" >
 <input type="hidden"   name="contenaire"  value="<?php      echo $contenaire; ?>" >
</form>
</table>