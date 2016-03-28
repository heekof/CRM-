<?php 

include("traitement_arbre.php");

//echo '<br> mon test1='.$test1.'et sa longueur='.strlen($test1) ;

 ?>
<table border="0"  width="10%" cellspacing="0"  cellpadding="0" >

<tr align="center" style="<?php if(strlen($test1)==0) echo  "display:none;";?>"  >
	<td ><input  name="A1ds" type="hidden" value="<?php echo "A1"; ?>" size="10" maxlength="20" disabled="disabled" />  
	<td>precedent:<input  name="A1" type="<?php if(strlen($test1)!=0) echo "text"; else echo "hidden"; ?>"  value="<?php  if(strlen($test1)!=0)echo $Vheritager; else echo "";  ?>" size="10" maxlength="20" disabled="disabled" />  
</tr>
<tr>
	<td><input  name="A1ds" type="hidden" value="<?php echo "A1"; ?>" size="10" maxlength="20" disabled="disabled" />  
	<td align="center" width="100" ><input type="<?php if(strlen($test1)!=0) echo "image"; else echo "hidden"; ?>" src="F4.png"  name="F4" value="F4">
</tr>
<tr>
	<td ><input  name="A1ds" type="hidden" value="<?php echo "A1"; ?>" size="10" maxlength="20" disabled="disabled" />  
	<td align="center" >Vous etes la:<input  name="A1" type="text" value="<?php  echo $Vactuel; ?>" size="10" maxlength="20" disabled="disabled" /> 
</tr>
<tr height="20" >
	<td align="right" width="100" style="<?php if($Voui==NULL) echo  "display:none;";?>" ><input type="image" src="F1.png"  name="F1" value="F1">
	<td align="center" width="100" style="<?php if($Vnon==NULL) echo  "display:none;";?>" ><input type="image" src="F2.png"  name="F2" value="F2">
	<td align="left"  width="100" style="<?php if($Vind==NULL) echo  "display:none;";?>" ><input type="image" src="F3.png"  name="F3" value="F3">
</tr>
<tr >
	<td style="<?php if($Voui==NULL) echo  "display:none;";?>" align="center" >oui:<input name="A2" type="text" value="<?php echo $Voui; ?>" size="10" maxlength="20" disabled="disabled" />  
	<td align="center"  style="<?php if($Vnon==NULL) echo  "display:none;";?>" >non:<input name="A3" type="text" value="<?php echo $Vnon; ?>" size="10" maxlength="20" disabled="disabled" />
	<td align="center" style="<?php if($Vind==NULL) echo  "display:none;";?>" >indecis:<input name="A4" type="text" value="<?php echo $Vind; ?>" size="10" maxlength="20" disabled="disabled" />  
</tr>
<tr>
	<td><table>
		<td align="right" style="<?php if($Vouioui==NULL) echo  "display:none;";?>" width="100" ><input type="image" src="F1.png"  name="F1" value="F1">
		<td align="center"style="<?php if($Vouinon==NULL) echo  "display:none;";?>"  width="100" ><input type="image" src="F2.png"  name="F2" value="F2">
		<td align="left" style="<?php if($Vouiind==NULL) echo  "display:none;";?>"  width="100" ><input type="image" src="F3.png"  name="F3" value="F3">
	
	</table></td>
	
	<td><table> 
		<td align="right"style="<?php if($Vnonoui==NULL) echo  "display:none;";?>" width="100" ><input type="image" src="F1.png"  name="F1" value="F1">
		<td align="center" style="<?php if($Vnonnon==NULL) echo  "display:none;";?>" width="100" ><input type="image" src="F2.png"  name="F2" value="F2">
		<td align="left" style="<?php if($Vnonind==NULL) echo  "display:none;";?>" width="100" ><input type="image" src="F3.png"  name="F3" value="F3">
	
	</table></td>
	<td><table>
		<td align="right" style="<?php if($Vindoui==NULL) echo  "display:none;";?>" width="100" ><input type="image" src="F1.png"  name="F1" value="F1">
		<td align="center" style="<?php if($Vindnon==NULL) echo  "display:none;";?>" width="100" ><input type="image" src="F2.png"  name="F2" value="F2">
		<td align="left" style="<?php if($Vindind==NULL) echo  "display:none;";?>"  width="100" ><input type="image" src="F3.png"  name="F3" value="F3">
	
	
	</table></td>
	
</tr>
<tr>
		<td><table>
		<td align="center"  style="<?php if($Vouioui==NULL) echo  "display:none;";?>" >oui:<input name="A5" type="text" value="<?php echo $Vouioui; ?>" size="10" maxlength="20" disabled="disabled" />  
		<td align="center" style="<?php if($Vouinon==NULL) echo  "display:none;";?>" >non:<input name="A6" type="text" value="<?php echo $Vouinon; ?>" size="10" maxlength="20" disabled="disabled" />
		<td align="center" style="<?php if($Vouiind==NULL) echo  "display:none;";?>" >indecis:<input name="A7" type="text" value="<?php echo $Vouiind; ?>" size="10" maxlength="20" disabled="disabled" />  
		</table></td>
		<td><table>
		<td align="center"style="<?php if($Vnonnon==NULL) echo  "display:none;";?>" >oui:<input name="A8" type="text" value="<?php echo $Vnonoui; ?>" size="10" maxlength="20" disabled="disabled" />  
		<td align="center" style="<?php if($Vnonoui==NULL) echo  "display:none;";?>" >non:<input name="A9" type="text" value="<?php echo $Vnonnon; ?>" size="10" maxlength="20" disabled="disabled" />
		<td align="center" style="<?php if($Vnonind==NULL) echo  "display:none;";?>" >indecis:<input name="A10" type="text" value="<?php echo $Vnonind; ?>" size="10" maxlength="20" disabled="disabled" />  
		</table></td>
		<td><table>
		<td align="center" style="<?php if($Vindoui==NULL) echo  "display:none;";?>" >oui:<input name="A11" type="text" value="<?php echo $Vindoui; ?>" size="10" maxlength="20" disabled="disabled" />  
		<td align="center"  style="<?php if($Vindnon==NULL) echo  "display:none;";?>">non:<input name="A12" type="text" value="<?php echo $Vindnon; ?>" size="10" maxlength="20" disabled="disabled" />
		<td align="center" style="<?php if($Vindind==NULL) echo  "display:none;";?>" >indecis:<input name="A13" type="text" value="<?php echo $Vindind; ?>" size="10" maxlength="20" disabled="disabled" />  
		</table></td>

</tr>
</table>