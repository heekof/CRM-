<br>
<br>
<table border="0"  align="center" width="60%" >
	<tr align="center">
		<td bgcolor="#CCCCCC"><input type="button" onclick="history.back();" value="Retour"><b>Importer une base Externe - csv : 2/3 </b></td>
	</tr>
</table>

<table border="2"  align="center" width="90%" >

<tr align="left">

<td>

<!--form method="post"  action="crm1.php" onsubmit="return checkbase();"-->
<form method="post"  action="crm1.php" id="formBD">
<p>

<h2 id="msgdispo" style="color:green" align="center"></h2>
<input type="hidden" name="page" value="import1">
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b> Nom de votre Base </b>    &nbsp;
<!--input type="text" size="20"  name="nominsertion" id="base" value="" onchange="checkbase();"/-->
<input type="text" size="20"  name="nominsertion" id="base"/>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<b> Separateur de colonne</b> &nbsp; 

<SELECT name="separation">
	<OPTION value=";"> Point virgule  ; </option>
	<OPTION value=":"> Deux point :  </option>
	<OPTION value="-"> Tirait  -  </option>
</SELECT>
<br>
<br>

&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
<b> Nom &nbsp; Pr&eacute;nom &nbsp; T&eacute;l&eacute;phone &nbsp;&Eacute;-mail &nbsp;
<?php 	
	$optChoisis = "";
	for($i=1; $i<=6; $i++)
	{
		if(${"option".$i})
		{
			$optChoisis .= $i."-";
			echo ${"labeloption".$i}.'&nbsp;';
			echo '<input type="hidden" id="labeloption'.$i.'" name="labeloption'.$i.'" value="'.${"labeloption".$i}.'" >';
			echo '<input type="hidden" id="typeoption'.$i.'" name="typeoption'.$i.'" value="'.${"typeoption".$i}.'" >';
		}
	}
	if(strlen($optChoisis)>0)
		$optChoisis = substr($optChoisis,0,strlen(optChoisis)-1);
	echo '<input type="hidden" id="optionsChoisis" name="optionsChoisis" value="'.$optChoisis.'" >';
?>
<span id="labelOption1"></span>&nbsp;<span id="labelOption2"></span></b>

<center>
<TEXTAREA ROWS="25" COLS="80" name="labase"></TEXTAREA>
</center>
<br>
<h2 id="msgerreur" style="color:red" align="center"></h2>
<br>
<p Align="center">
<input type="button"  value="Enregistrer" onclick="checkbase();">
</p>

</p>
</form>

 </td>
</tr>
</table>

