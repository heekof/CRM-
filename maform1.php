<form method="POST" action="crm1.php"> 

<input type="hidden" id="p" name="p" value=<?php echo $p+1;?> >
<input type="hidden" name="page" value="jaafar">
<input type="hidden" name="argument" value="1">
<!-- affichage de la requete mysql 
<input type="text" name=<?php //echo 'entry'.$p; ?> value="<?php //echo $Vheritage;?>"  size="100" style="height:300px"    >
-->
<?php//  echo "<br>text1=".$test2."niveau=".$p." val=".$Vheritage;;?>
<tr style="<?php if($p==1) echo  "display:none;";?>">
	<td  >
	
	</td>
	
	<td  ><p style="text-align: center;"><input name="ch_texte" type="text" value="<?php  echo $Vheritager; ?>" size="60"  maxlength="1000000" disabled="disabled" />  
	</p>
	
	</td  >
	
	<td >
	
	</td>
</tr>
<tr width="100%" align="center" >
			<td  >
			
			</td>
			<td    >
			<TEXTAREA  width="100%" cols="70"  rows="4" maxlength="1000000" name="<?php echo 'entry'.$p; ?>"  value="<?php //echo $Vheritage;?>" size="150" style="height:300px" ><?php  if($p==1 && isset($ret1)) echo $Vheritager; else echo $Vheritage;?></TEXTAREA>
			</td>
			<td> <a       target="_self"   href="crm1.php?page=arbre"   ><img src="info.png">cliquer ici pour afficher l'arbre </a><!--<input type="image" src="info.png"  name="tree" value="OK" onClick="pop()" >-->
		<!--	<meta http-equiv="refresh" content="0;URL=<?php echo "arbre.php" ?>" /> -->
			
			</td>
</tr>
<!-- declaration de p de type hidden pour la sauvegarde et l'envoi 
<input type="hidden" id="p" name="p" value=<?php   //echo 1;// echo $p+1;?> >-->
<!-- variable retour -->
<input type="hidden"  name="lolo" value="<? echo $monretour; ?>" >
<!-- variable colonne -->
<tr align="center" >
	<td>
	<!-- deux boutons oui et non leurs noms est clicki --> 
	<input type="hidden" >
	</td>
	<td> <input type="hidden" name="abc">
	<input type="image" src="oui.png"  name=<?php echo 'clik'.$p; ?> value="oui">
	<input type="image" src="non.png"  name=<?php echo 'clik'.$p; ?> value="non">
	<input type="image" src="ind.png"  name=<?php echo 'clik'.$p; ?> value="ind" >
    </td>
<!-- compte le nombre de reponses 
<input type="hidden" name="oui" value=<?php // $l=$p-1;$vari="clik";$reponse=${$vari.$l};if($reponse=="oui") {echo $oui+1;} else echo $oui;?> >
<input type="hidden" name="non" value=<?php //$l=$p-1; $vari="clik"; $reponse=${$vari.$l}; if($reponse=="non") {echo $non+1;}else echo $non; ?> >
-->
<td>
<input type="hidden" >
</td>
</tr>
<!-- envoie de la variable mavar4 -->
 <input type="hidden" name="mavar4" value="<?php echo $_POST['mavar4']; ?>" >
<input type="hidden"  name="test" value="<?   echo $mavar4; ?>" >
<?// echo "<br><br> La variable que je viens de creer =".$test1.'<br><br>' ; ?>
<input type="hidden"  name="test1" value="<?  if(!isset($ret1) /*&& $lolo!=1 */){$test1.=$mavar4; } echo $test1; ?>" >


</form>
<form method="post" action="crm1">
  <tr align="right"> 
 <td align="right"><input  align="right" type="hidden" name="page" value="activapreview2" >
 <td><input  name="valider" value="valider" type="submit" >
 </tr>
</form> 


