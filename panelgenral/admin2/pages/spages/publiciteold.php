<?php
$query = " SELECT * FROM pub WHERE numpub='".$_GET['numpub']."'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());

while($row = mysql_fetch_array($mysql_result))
                              {
							          $message= ($row["contenu"]);
									  $numpub = ($row["numpub"]);
									  $idsignature = ($row["signature"]);
									  $etatpub = ($row["etat"]);
									  $format = ($row["format"]);
									  $ob = ($row["objet"]);
									  $sempro = ($row["semaine"]);
									  }
?>
<html>
<head>


<script type="text/javascript" src="editeur/ckeditor.js"></script>
<script src="sample.js" type="text/javascript"></script>
<link href="sample.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table  width="100%" bgcolor="#808080" border="3" align="center" >
<td>
<br>
<b>
<center> ADMIN GENERALE PUBLICITE</center>
</b>
<br><br><br>
</td>

<td Bgcolor="white">
 <a href="?page=publicite&spage=publicite"> Acceuil </a> <br>
 <a href="?page=listedepub&spage=listedepub">Publicites </a> <br>
 

</td>
</table>

<form action="" method="post"   >
        <input type="hidden" name="page" value="listedepub" />
      <input type="hidden" name="spage" value="listedepub" />
	 
	 <?php if(isset($_GET['numpub'])){
	 ?>
	   <input type="hidden" name="numpub" value="<?php echo $_GET['numpub'];?>" />
	  <input type="hidden" name="update" value="update" />
	  <?php
	 }
	 else
	 {
	 ?>
	  <input type="hidden" name="add" value="add" />
	  <?php
	  }
	  ?>
<table width="%80" height="470" border="2" align="center" cellpadding="6" cellspacing="0">

<TR>
	<TD><b> Etat </b> </TD>
	<TD>
	Test <INPUT type=radio name="etat" value="1" <?php if($etatpub==1){echo 'checked="checked"';}?> onclick="document.getElementById('semaines').style.display='none';">
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
	Production: <INPUT type=radio name="etat" value="2" <?php if($etatpub==2){echo 'checked="checked"';}?>  onclick="document.getElementById('semaines').style.display='';">
	
	</TD>
</TR>

<tr>
     <td> <b> Email d envoie </b> </td>
     <td> <input type="text" name="email" size="20" id="dest" value="<?php echo $dest;?>" />
	 &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
	Email de retour (test)  &nbsp; &nbsp; &nbsp;      
<input type="text" name="email1" size="30" value="<?php echo $exp;?>" />
      </td>
</tr>

<tr>
     <td> <b> format du mail </b> </td>
     <td> Text <INPUT type=radio name="format" value="text" <?php if($format=="text"){echo 'checked="checked"';}?> onclick="document.getElementById('editeur1').style.display='none';document.getElementById('editeur2').style.display='';">
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
	html: <INPUT type=radio name="format" value="html" <?php if($format=="html" or $format==""){echo 'checked="checked"';}?> onclick="document.getElementById('editeur2').style.display='none';document.getElementById('editeur1').style.display='';">
	
      </td>
</tr>
<tr id="semaines" <?php if($sempro!=0){echo'style=" "';} else {echo'style="display:none;"';}?>>
     <td> <b> Semaine : </b> </td>
     <td>

     <SELECT name="id_semaine" >

	 <OPTION VALUE="" >choisir la semaine</OPTION>
<?php
$sel = mysql_query("select semaine from pub where semaine=1");
if(mysql_num_rows($sel)== 0 or $sempro==1){
?>
<OPTION VALUE="1" <?php if($sempro==1){echo ' selected="selected"';} ?>>1ere semaine</OPTION>
<?php
}
$sel2 = mysql_query("select semaine from pub where semaine=2");
if(mysql_num_rows($sel2)== 0 or $sempro==2){
?>
<OPTION VALUE="2" <?php if($sempro==2){echo ' selected="selected"';} ?>>2eme semaine</OPTION>
<?php
}
$sel3 = mysql_query("select semaine from pub where semaine=3");
if(mysql_num_rows($sel3)== 0 or $sempro==3){
?>
<OPTION VALUE="3" <?php if($sempro==3){echo ' selected="selected"';} ?>>3eme semaine</OPTION>
<?php
}
$sel4 = mysql_query("select semaine from pub where semaine=4");
if(mysql_num_rows($sel4)== 0 or $sempro==4){
?>
<OPTION VALUE="4" <?php if($sempro==4){echo ' selected="selected"';} ?>>4eme semaine</OPTION>
<?php
}
?>
</SELECT>


     </td>
</tr>
  <tr>
    <td><label for="editor1" style="font-family:verdana; font-size:11px;">Nom de la publicite:</label></td>
    <td><input class="ckeditor" style="width:355px;" id="ob" value="<?php echo $ob;?>" name="ob"></td>
  </tr>

  <tr id="editeur1" <?php if($format=="text"){echo "style='display:none;'";}?>>
    <td height="335" colspan="2">
     <textarea class="ckeditor"  cols="10" id="editor1" name="editor1" rows="5"><?php echo $message;?></textarea>  
 	 </td>
  </tr>

    <tr id="editeur2" <?php if($format=="html" or $format==""){echo "style='display:none;'";}?>>
    <td height="335" colspan="2">

     <textarea cols="210" id="editor2" name="editor2" rows="23"><?php echo $message;?></textarea>  
	 
	 </td>


	 </tr>
  
<tr>
  <td>Signature : </td>
  <td>
	<?php
	$query = "select * from mailparametre;";
		if($result = mysql_query($query) or die ("Erreur : ".mysql_error()))
		{
			echo '<select name="idsignature">';
			while($row = mysql_fetch_array($result))
			{
				$numero = $row['numero'];
				$nom = $row['nom'];
				echo '<option value="'.$numero.'"';
				if($idsignature == $numero) echo ' selected="selected"';
				echo '>'.$nom.'</option>';
			}
			echo '</select>';
		}
	?>
  </td>
  </tr>
  
  <tr>

  <td><input type="submit" value="ENVOYER"   /></td>
  <td></td>
  </tr>

</table>

</form>
</body>
</html>

